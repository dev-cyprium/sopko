<?php

namespace App\Repo;

use App\Models\Image;
use App\Facades\Sopko;
use App\Models\Storage as AppStorage;
use App\Repo\DTO\StorageCollectionDTO;
use App\Repo\DTO\BaseDTO;

class StorageRepository extends EloquentRepository 
{
    public function model() 
    {
        return AppStorage::class;
    }

    public function getAll()
    {
        $account = Sopko::get('account');
        $paginator = AppStorage::where('account_id', $account->id)->paginate($this->perPage);

        $items = collect($paginator->items())->map(function($item) { return BaseDTO::intoDTO($item); });

        return new StorageCollectionDTO($items, $paginator);
    }
}