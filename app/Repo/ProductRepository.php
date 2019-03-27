<?php

namespace App\Repo;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Auth\Access\AuthorizationException;
use App\Facades\Sopko;
use App\Models\Storage;
use Carbon\Carbon;

// TODO: add interface
class ProductRepository extends EloquentRepository
{
    public function model() 
    {
        return Product::class;
    }

    /**
     * Binds the images to the stored model.
     * Must be called after $this->model is saved
     * to the database.
     */
    public function bindImages(array $imageHashs) 
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

    public function newPrice(int $price, string $slug = null)
    {
        $price = $this->model->prices()->make(compact('price'));
        $price->group_slug = $slug;
        $price->save();
    }   

    public function bindStorage(int $idStorage, int $quantity)
    {
        $storage = Storage::find($idStorage);
        // TODO: check if storage belongs to account
        $this->model->storages()->attach($storage, compact('quantity'));
    }

    public function bindSales(array $sales) 
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

    public function bindUserGroups(array $groups)
    {
        $account = Sopko::get('account');  
        collect($groups)
            ->map(function($data) use ($account) {
                if(array_key_exists('group', $data)) {
                    $label = $data['group']['label'];
                    $slug  = md5($account->salt . $label);

                    $account->userGroups()->create(compact('slug', 'label'));
                    return [
                        'group_name' => $label,
                        'price' => $data['price'],
                    ];
                }

                return $data;
            })
            ->each(function ($group_with_names) use ($account) {
                $slug = md5($account->salt . $group_with_names['group_name']);
                $this->newPrice($group_with_names['price'], $slug);
            });
    }
}