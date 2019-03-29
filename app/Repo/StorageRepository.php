<?php

namespace App\Repo;

use App\Models\Image;
use App\Models\Account;
use App\Repo\DTO\BaseDTO;
use App\Repo\DTO\ImageCollectionDTO;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StorageRepository extends EloquentRepository 
{
    public function model() 
    {
        return Image::class;
    }

    
}