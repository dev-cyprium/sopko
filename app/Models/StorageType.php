<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorageType extends Model
{
    public function storages()
    {
        return $this->hasMany(Storage::class, 'type_id');
    }
}
