<?php

namespace App\Repo\DTO;

final class ImageDTO extends BaseDTO
{
    /**
     * This class is a final wraper for our API response to clients.
     * We use this to decouple from our backend implemetation and this
     * class shouldn't ever change
     */
    
     /**
      * The path for this image of the server
      * @var string 
      */
     public $path;

     /**
      * The created at field for this image
      * @var string
      */
     public $created_at;
}