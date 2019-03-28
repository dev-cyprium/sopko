<?php

namespace App\Repo;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Auth\Access\AuthorizationException;
use App\Facades\Sopko;
use App\Models\Storage;
use Carbon\Carbon;
use App\Repo\DTO\BaseDTO;
use App\Repo\DTO\ProductCollectionDTO;
use App\Repo\Contracts\ProductContract;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

// TODO: add interface
class ProductRepository extends EloquentRepository implements ProductContract
{
    public function model() 
    {
        return Product::class;
    }

    
    public function bindImages(array $imageHashs) : void 
    {
        $images = Image::whereIn('path', $imageHashs)
            ->where('account_id', Sopko::get('account')->id)
            ->get();
        
        if(count($imageHashs) !== $images->count()) {
            throw new AuthorizationException("You don't have access to the given images (or they don't exist)");
        }

        $images->each(function(&$image) { 
                $this->model->images()->attach($image);    
            });

        $this->model->save();
    }

    public function newPrice($price, string $slug = null) : void
    {
        $price = $this->model->prices()->make(compact('price'));
        $price->group_slug = $slug;
        $price->save();
    }

    public function bindStorage(int $idStorage, int $quantity) : void
    {
        $storage = Storage::find($idStorage);
        // TODO: check if storage belongs to account
        $this->model->storages()->attach($storage, compact('quantity'));
    }

    public function bindSales(array $sales) : void
    {
        $sales = collect($sales)
            ->map(function($sale) {   
                $start_date = Carbon::createFromFormat("Y-m-d", $sale['from']);
                $end_date  = Carbon::createFromFormat("Y-m-d", $sale['to']);
                $percent = $sale['percent'] ?? null;
                $value   = $sale['value']   ?? null;

                return $this->model
                    ->sales()
                    ->make(compact('percent', 'value', 'start_date', 'end_date'));
            });


        $this->model->sales()->saveMany($sales);
    }

    public function bindUserGroups(array $groups) : void
    {
        $account = Sopko::get('account');  
        collect($groups)
            ->map(function($data) use ($account) {
                if(array_key_exists('group', $data)) {
                    $label = $data['group']['label'];
                    $slug  = md5($account->salt . strtolower($label));

                    $account->userGroups()->create(compact('slug', 'label'));
                    return [
                        'group_name' => $label,
                        'price' => $data['price'],
                    ];
                }

                return $data;
            })
            ->each(function ($group_with_names) use ($account) {
                $slug = md5($account->salt . strtolower($group_with_names['group_name']));
                $this->newPrice($group_with_names['price'], $slug);
            });
    }

    /**
     * @override getAll
     * We override the default Eloquent's way to fetch all by adding pagination
     * and our own logic to it
     */
    public function getAll() 
    {
        $result = $this->getData();
        $items = collect($result->items())
            ->map(function($product) { return BaseDTO::intoDTO($product); });
        
        return new ProductCollectionDTO($items, $result);
    }

    /**
     * Get the scope for a specific group and prices
     * scoped to that group.
     */
    public function getGroupScope($groupName) : ProductCollectionDTO
    {
        $account = Sopko::get('account');
        $slug = md5($account->salt . strtolower($groupName));
        $this->checkAnyData($account, $slug);
        $data = $this->getData();

        $result = collect($data->items())
            ->map(function($product) use ($slug) {
                $price = $product
                    ->activePrices
                    ->filter(function($price) use ($slug) {
                        return $price->group_slug === $slug;
                    })
                    ->first();
                // Exists price for user group
                if($price) {
                    $price = (double) $price->price;
                    return BaseDTO::intoDTO($product, compact('price'));
                } else {
                    $defaultPrice = $product
                        ->activePrices
                        ->filter(function ($price) {
                            return $price->group_slug === null;
                        })
                        ->first()
                        ->price;

                    return BaseDTO::intoDTO($product, ['price' => (double) $defaultPrice]);
                }
            });

        return new ProductCollectionDTO($result, $data);
    }

    private function checkAnyData($account, $slug) 
    {
        $any = Product::where('account_id', $account->id)
            ->whereHas('prices', function($q) use ($slug) {
                $q->where('group_slug', $slug);
            })
            ->get();
        
        if($any->isEmpty()) {
            throw new UnprocessableEntityHttpException("The category you're trying to fetch has no data");
        }
    }

    private function getData()
    {
        $account = Sopko::get('account');
        return Product::with(['storages', 'activePrices.userGroup', 'brand', 'category'])
            ->where('account_id', $account->id)
            ->paginate(Sopko::PER_PAGE);
    }
}