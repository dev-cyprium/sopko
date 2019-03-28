<?php

namespace App\Repo\DTO;

final class StorageDTO extends BaseDTO
{
    /**
     * This class is a final wraper for our API response to clients.
     * We use this to decouple from our backend implemetation and this
     * class shouldn't ever change
     */

    /**
     * Geo data
     * @var array
     */
    public $geo;

    /**
     * Storage name
     * @var string
     */
    public $name;

    /**
     * Storage address
     * @var string
     */
    public $address;
}


