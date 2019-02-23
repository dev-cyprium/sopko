<?php

namespace App\Repo\DTO;

final class AccountDTO extends BaseDTO
{
    /**
     * This class is a final wraper for our API response to clients.
     * We use this to decouple from our backend implemetation and this
     * class shouldn't ever change
     */
    
     /**
      * The full name of the account
      * @var string 
      */
     public $fullName;

     /**
      * The latest active apiKey
      * @var string
      */
     public $apiKey;
}