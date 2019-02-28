<?php

namespace App\Repo\DTO;

final class CategoryDTO extends BaseDTO
{
    /**
    * This class is a final wraper for our API response to clients.
    * We use this to decouple from our backend implemetation and this
    * class shouldn't ever change
    */

    public $parent_category_id;

    public $title;

    public $id;
}