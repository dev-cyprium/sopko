<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Repo\ProductRepository;
use App\Facades\Sopko;
use Illuminate\Support\Facades\DB;

class ProductController extends ApiController
{
    public function store(ProductRequest $request, ProductRepository $products)
    {
        DB::transaction(function () use ($products, $request) {
            $category_id = $request->input('category_id');
            $brand_id    = $request->input('brand_id');
            $name        = $request->input('name');
            $description = $request->input('description');
            $account_id  = Sopko::get('account')->id;

            $products->store(compact('name', 'description'), compact('category_id', 'brand_id', 'account_id'));
            $products->bindImages($request->input('image_paths'));
            $products->newPrice((int) $request->input('price'));
            $products->bindStorage((int) $request->input('storage_id'), (int) $request->input('quantity'));

            // TODO: add sales
            // TODO: add price groups
            1 / 0;
        });
        
        return $this->ok('Product created');
    }
}