<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'geo_lon', 'geo_lat', 'address', 'type_id'
    ];

    public function type() 
    {
        return $this->belongsTo(StorageType::class);
    }
}
