<?php

namespace App\Http\Controllers;

use App\Facades\Sopko;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductRequest;
use App\Repo\Contracts\ProductContract;

class ProductController extends ApiController
{
    protected $products;

    public function __construct(ProductContract $products)
    {
        $this->products = $products;
    }

    public function store(ProductRequest $request)
    {
        $products = $this->products;
        DB::transaction(function () use ($products, $request) {
            $category_id = $request->input('category_id');
            $brand_id    = $request->input('brand_id');
            $name        = $request->input('name');
            $description = $request->input('description');
            $account_id  = Sopko::get('account')->id;

            $products->store(compact('name', 'description'), compact('category_id', 'brand_id', 'account_id'));
            $products->bindImages($request->input('image_paths'));
            $products->newPrice(floatval($request->input('price')));
            $products->bindStorage((int) $request->input('storage_id'), (int) $request->input('quantity'));

            if($request->has('sales')) {
                $products->bindSales($request->input('sales'));
            }

            if($request->has('price_groups')) {
                $products->bindUserGroups($request->input('price_groups'));
            }
        });
        return $this->ok('Product created successfully');
    }

    public function index()
    {
        return $this->ok('Listing products.', $this->products->getGroupScope(null)->serialize());
    }

    public function show($priceGroup)
    {
        return $this->ok('Listing products.', $this->products->getGroupScope($priceGroup)->serialize());
    }
}