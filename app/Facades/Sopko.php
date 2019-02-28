<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;


class Sopko extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Sopko';
    }
}