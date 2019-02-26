<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    public function index()
    {
        return ["1" , "2", "3"];
    }
}