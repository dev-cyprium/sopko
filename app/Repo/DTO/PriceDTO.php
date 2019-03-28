<?php

namespace App\Repo\DTO;

final class PriceDTO extends BaseDTO
{
    /**
     * This class is a final wraper for our API response to clients.
     * We use this to decouple from our backend implemetation and this
     * class shouldn't ever change
     */
    
     /**
      * The user group this price belongs to
      * @var string
      */
     public $group;

     /**
      * The actual price
      * @var double
      */
     public $price;

     /**
      * TODO: parse to Carbon date.
      */
     public $created;
}