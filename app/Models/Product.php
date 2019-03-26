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

    public function storages()
    {
        return $this->belongsToMany(Storage::class, 'product_storages');
    }

    public function sales() 
    {
        return $this->hasMany(Sale::class);
    }
}
