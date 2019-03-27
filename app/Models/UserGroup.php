<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * This table uses custom primary keys so we disable the 
 * default Laravel's behaviour for primary keys
 */
class UserGroup extends Model
{
    protected $primaryKey = "slug";
    protected $fillable = [
        'slug', 'label' 
    ];
    
    public $incrementing = false;

}
