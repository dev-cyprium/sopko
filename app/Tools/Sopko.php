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
    private $observers = [];

    public function remember($key, $val) 
    {
        collect($this->observers)->each(function($observer) use ($key, $val) {
            if($key === $observer['key']) {
                $observer['callback']($val);
            }
        });
        $this->store[$key] = $val;
    }

    public function get($key)
    {
        return $this->store[$key];
    }

    public function observe($key, \Closure $callback) 
    {
        $this->observers[] = [
            'key' => $key,
            'callback' => $callback
        ];
    }
}