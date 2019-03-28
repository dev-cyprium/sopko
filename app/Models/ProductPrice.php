<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    protected $fillable = [
        'price'
    ];

    public function userGroup() 
    {
        return $this->belongsTo(UserGroup::class, 'group_slug', 'slug');
    }
}
