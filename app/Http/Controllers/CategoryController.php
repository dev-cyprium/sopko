<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\Sopko;
use App\Repo\Contracts\CategoryContract;

class CategoryController extends ApiController
{
    public function index(CategoryContract $categoryProvider)
    {
        $categories = $categoryProvider->fetchAccountCategories(Sopko::get('account'));
        return $this->ok('Categories retreived', $categories->serialize());
    }
}