<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description'
    ];

    public function images()
    {
        return $this->morphToMany(Image::class, 'imaggable');
    }

    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function activePrices()
    {
        return $this->hasMany(ProductPrice::class)
            ->selectRaw('max(created_at) as created, product_id, price, group_slug')
            ->groupBy(['product_id', 'group_slug', 'price']);
    }

    public function storages()
    {
        return $this->belongsToMany(Storage::class, 'product_storages');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function sales() 
    {
        return $this->hasMany(Sale::class);
    }
}
