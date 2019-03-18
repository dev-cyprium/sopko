<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends ApiController
{
    public function store(Request $request)
    {
        $ext = $this->mimeType($request->header('Content-Type'));
        $image = $request->getContent();
        $name = ((string) Str::uuid()) . "_" . time();
        Storage::disk('public')->put("$name.$ext", $image);
        return $this->ok("Successfully uploaded image", [
            "path" => "$name.$ext"
        ]);
    }

    private function mimeType($header)
    {
        $types = [
            "image/png"  => "png",
            "image/jpeg" => "jpg",
            "image/jpg"  => "jpg",
        ];
        
        return $types[$header];
    }
}