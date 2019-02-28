<?php

namespace App\Repo\DTO;
use App\Repo\DTO\BaseDTO;

class CategoryCollectionDTO extends BaseDTO
{
    public $categories;

    public function __construct($categories)
    {
        $this->categories = $categories;
    }
}