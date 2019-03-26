<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Repo\ProductRepository;
use App\Facades\Sopko;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\AuthenticationException;

class ProductController extends ApiController
{
    public function store(ProductRequest $request, ProductRepository $products)
    {
        DB::enableQueryLog();
        try {

        
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


                if($request->has('sales')) {
                    $products->bindSales($request->input('sales'));
                }

                if($request->has('price_groups')) {

                }

                1/0;
            });
        
        } catch(\Exception $e) {
            return $this->ok(DB::getQueryLog());
        }
        return $this->ok('Product created');
    }
}