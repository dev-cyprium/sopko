<?php

namespace App\Repo\DTO;

use App\Models\ProductCategory;
use App\Models\Image;
use App\Models\Account;
use App\Models\Product;
use App\Models\Storage;

/* TODO: Rename Factory to DTOMapper or just AutoMapper
   TODO: Change function names to static */
class AutoMapper
{
    private static $instance = null;

    protected $bindings = [
        ProductCategory::class => 'productCategory',
        Image::class => 'image',
        Account::class => 'account',
        Product::class => 'product',
        Storage::class => 'storage',
    ];

    protected $flags;

    public static function make()
    {
        if(self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function intoDTO($modelInstance, string $class = null, array $flags = []) {
        if(!$class) {
            $class = get_class($modelInstance);
        }

        if(array_key_exists($class, $this->bindings)) {
            $method = $this->bindings[$class];
            
            $this->flags = $flags;
            return $this->{$method}($modelInstance);
        } else {
            return $modelInstance;
        }
    }

    private function productCategory($model)
    {
        $dto = new CategoryDTO;
        $dto->id = $model->id;
        $dto->parent_category_id = $model->parent_id;
        $dto->title = $model->title;
        return $dto;
    }

    private function account($model)
    {
        $dto = new AccountDTO;
        $dto->apiKey = $model
                ->authKeys() // #TODO add ->where('valid')
                ->orderBy('created_at', 'desc')
                ->first()
                ->hash;
        $dto->fullName = $model->full_name;
        return $dto;
    }

    private function image($model) 
    {
        $dto = new ImageDTO;
        $dto->path = 'storage/' . $model->path;
        $dto->created_at = $model->created_at;
        return $dto;
    }

    private function storage($model)
    {
        $dto = new StorageDTO;
        $dto->address = $model->address;
        $dto->geo = [
            'lat' => $model->geo_lat,
            'lon' => $model->geo_lon
        ];
        $dto->name = $model->name;
        return $dto;
    }

    private function product($model)
    {
        $flags = $this->flags;
        $dto = new ProductDTO;
        $dto->name = $model->name;
        $dto->description = $model->description;
        $dto->category = $this->intoDTO($model->category);
        $dto->brand = $model->brand->name;
        
        
        if(isset($flags['price'])) {
            /* public data */
            $dto->ignore('prices');
            $dto->ignore('storages');
            $dto->price = $flags['price'];
        } else {
            /* admin panel data */
            $dto->ignore('price');
            $dto->storages = $model->storages->map(function($storage) { 
                return $this->intoDTO($storage);
            });
            $dto->prices = $model->activePrices->map(function ($price) { 
                $priceDTO = new PriceDTO;
                if($price->userGroup) {
                    $priceDTO->group = $price->userGroup->label;
                }
                $priceDTO->price = (double) $price->price;
                $priceDTO->created = $price->created;
                return $priceDTO;
            });
        }


        return $dto;
    }
}