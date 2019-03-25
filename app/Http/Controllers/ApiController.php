<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Tools\ResponseCodes;

// TODO: add static requests consatnts for a status codes in static class...
abstract class ApiController extends Controller
{
    protected function ok($message, $extra = [])
    {
        return $this->json(array_merge(["message" => $message], $extra));
    }

    protected function forbidden($message, $extra = [])
    {
        return $this->json(array_merge(["message" => $message], $extra), ResponseCodes::FORBIDDEN);
    }

    private function json($obj, $status = ResponseCodes::OK) 
    {
        return response()->json($obj, $status);
    }
}