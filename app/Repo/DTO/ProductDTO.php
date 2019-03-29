<?php

namespace App\Repo\DTO;

final class ProductDTO extends BaseDTO
{
    /**
     * This class is a final wraper for our API response to clients.
     * We use this to decouple from our backend implemetation and this
     * class shouldn't ever change
     */

    /**
      * The name of this product
      * @var string 
      */
    public $name;

    /**
      * The Description of this product
      * @var string
      */
    public $description;

    /**
      * The storages where thisproduct is located
      * @var array
      */
    public $storages;

    /**
      * The prices for this product per user group
      * @var array
      */
    public $prices;


    /**
     * The price of this product
     * @var double
     */
    public $price;

    /**
     * The category belonging to this product
     * @var CategoryDTO
     */
    public $categories;

    /**
     * The brand of this product
     * @var string
     */
    public $brand;
}

