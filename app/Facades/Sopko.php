<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Session;

/**
 * @method static mixed get(string $key)
 * @method static void remember(string $key, mixed $value)
 */
class Sopko extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Sopko';
    }
}