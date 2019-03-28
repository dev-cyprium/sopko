<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Session;

/**
 * @method static mixed get(string $key)
 */
class Sopko extends Facade
{
    public const PER_PAGE = 10;

    protected static function getFacadeAccessor()
    {
        return 'Sopko';
    }
}