<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\Sopko;
use App\Repo\Contracts\CategoryContract;
use App\Http\Requests\ProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;

class CategoryController extends ApiController
{
    /**
     * The provider for category related database operations
     * @var CategoryContract
     */
    protected $categoryProvider;

    public function __construct(CategoryContract $categoryProvider)
    {
        $this->categoryProvider = $categoryProvider;
    }

    public function index()
    {
        $categories = $this->categoryProvider->fetchAccountCategories(Sopko::get('account'));
        return $this->ok('Categories retreived', $categories->serialize());
    }

    public function store(ProductCategoryRequest $request) 
    {
        $parent_id = $request->input('parent_category_id');
        $title = $request->input('title');
        $category = $this->categoryProvider->store(compact(['parent_id', 'title']), ['account_id' => Sopko::get('account')->id]);
        return $this->ok('Successfully added new category', compact('category'));
    }

    public function update($id, UpdateProductCategoryRequest $request) 
    {
        $title = $request->input('title');
        $this->categoryProvider->setModel($id);
        if($request->has('parent_category_id')) {
            $parent_id = $request->input('parent_category_id');
            $this->categoryProvider->store(compact('parent_id', 'title')); 
        } else {
            $this->categoryProvider->store(compact('title'));
        }
        return $this->ok('Successfully updated category');
    }

    public function destroy($id)
    {
        $this->categoryProvider->destroy($id);
        return $this->ok('Successfully deleted category');
    }
}