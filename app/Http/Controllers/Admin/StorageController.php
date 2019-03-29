<?php

namespace App\Http\Controllers\Admin;

use App\Repo\ProductRepository;
use App\Http\Controllers\ApiController;
use App\Repo\StorageRepository;
use App\Http\Requests\StorageRequest;

class StorageController extends ApiController
{
    public function index(StorageRepository $storages)
    {
        return $this->ok("Listing Storages", $storages->getAll()->serialize());
    }

    public function store(StorageRequest $request, StorageRepository $storages)
    {
        $geo_lat = $request->input('geo_lat');
        $geo_lon = $request->input('geo_lon');
        $address = $request->input('address');
        $type_id = $request->input('type_id');  
        $name    = $request->input('name');
        $storages->store(compact('geo_lat', 'geo_lon', 'address', 'type_id', 'name'));
        return $this->ok("Successfully made a new Storage");
    }
}

