<?php

namespace App\Http\Controllers\Admin;

use App\Repo\ProductRepository;
use App\Http\Controllers\ApiController;
use App\Repo\Contracts\ProductContract;

class ProductController extends ApiController
{
    public function index(ProductContract $products) 
    {
        return $this->ok('Listing Admin products.', $products->getAll()->serialize());
    }
}
