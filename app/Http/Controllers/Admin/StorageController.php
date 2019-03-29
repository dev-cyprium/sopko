<?php

namespace App\Http\Controllers\Admin;

use App\Repo\ProductRepository;
use App\Http\Controllers\ApiController;
use App\Repo\StorageRepository;

class StorageController extends ApiController
{
    public function index(StorageRepository $storages)
    {
        return $this->ok("Listing Storages", $storages->getAll()->serialize());
    }
}
