<?php

namespace App\Tools;

/**
 * Sopko application class is used to remember 
 * various variables througout request.
 * 
 * Can be used as an "in-memory" cache per request
 */
class Sopko
{
    private $store;

    public function remember($key, $val) 
    {
        $this->store[$key] = $val;
    }

    public function get($key)
    {
        return $this->store[$key];
    }
}