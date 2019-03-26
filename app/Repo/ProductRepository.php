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

    public function newPrice(int $price, int $group_id = null)
    {
        $price = $this->model->prices()->make(compact('price'));
        $price->group_id = null;
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
                $stat_date = Carbon::createFromFormat("Y-m-d", $sale['from']);
                $end_date  = Carbon::createFromFormat("Y-m-d", $sale['to']);
                $percent = $sale['percent'] ?? null;
                $value   = $sale['value']   ?? null;

                return $this->model
                    ->sales()
                    ->make(compact('percent', 'value', 'start_date', 'end_date'));
            });


        $this->model->sales()->saveMany($sales);
    }
}