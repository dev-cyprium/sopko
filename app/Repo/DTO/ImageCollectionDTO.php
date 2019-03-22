<?php

namespace App\Repo\DTO;
use App\Repo\DTO\BaseDTO;

class ImageCollectionDTO extends BaseDTO
{
    public $images;

    public function __construct($images)
    {
        $this->images = $images;
    }
}