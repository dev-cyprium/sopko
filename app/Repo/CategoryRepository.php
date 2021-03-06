<?php

namespace App\Repo;

use App\Repo\Contracts\CategoryContract;
use App\Models\Account;
use App\Models\ProductCategory;
use App\Repo\DTO\CategoryDTO;
use App\Repo\DTO\CategoryCollectionDTO;

class CategoryRepository extends EloquentRepository implements CategoryContract
{
    public function model()
    {
        return ProductCategory::class;
    }
    

    /**
     * We need to override parent destroy
     * because of recursive deletion
     */
    public function destroy($id)
    {
        $this->recursiveDelete($this->model->find($id));
    }

    public function fetchAccountCategories(Account $account) : CategoryCollectionDTO
    {
        $accountCategories = $account->categories->toArray();
        $globalCategories  = ProductCategory::where('account_id', null)->get()->toArray();
        $dtos = [];
        $allCategories = array_merge($accountCategories, $globalCategories);
        foreach($allCategories as $category) {
            $dto = new CategoryDTO;
            $dto->id = $category['id'];
            $dto->parent_category_id = $category['parent_id'];
            $dto->title = $category['title'];
            $dtos[] = $dto; 
        }
        return new CategoryCollectionDTO($dtos);
    }

    private function recursiveDelete($category) 
    {
        if($category->subCategories) {
            foreach($category->subCategories as $c) {
                $this->recursiveDelete($c);
            }
        }
        
        $category->delete();
    }
}