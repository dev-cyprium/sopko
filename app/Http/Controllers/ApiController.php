<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;


abstract class ApiController extends Controller
{
    protected function ok($message)
    {
        return $this->json(["message" => $message]);
    }

    private function json($obj, $status = 200) 
    {
        return response()->json($obj, $status);
    }
}