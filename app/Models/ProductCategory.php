<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = [
        'parent_id', 'title'
    ];

    public function parentCategory()
    {
        return $this->belongsTo(self::class, 'parent_id')->with('parentCategory');
    }

    public function subCategories() 
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
