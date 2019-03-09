<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\Sopko;
use App\Repo\Contracts\CategoryContract;
use App\Http\Requests\ProductCategoryRequest;

class CategoryController extends ApiController
{
    public function index(CategoryContract $categoryProvider)
    {
        $categories = $categoryProvider->fetchAccountCategories(Sopko::get('account'));
        return $this->ok('Categories retreived', $categories->serialize());
    }

    public function store(ProductCategoryRequest $request, CategoryContract $categoryProvider) 
    {
        $categoryProvider->store($request->all(), ['account_id' => Sopko::get('account')->id]);
        return $this->ok('Successfully added new category');
    }
}