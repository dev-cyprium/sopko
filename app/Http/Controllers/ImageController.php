<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Repo\Contracts\ImageContract;
use App\Facades\Sopko;
use App\Http\Requests\ImageRequest;
use App\Models\Image;

class ImageController extends ApiController
{
    public function index(ImageContract $images)
    {
        $account = Sopko::get("account");
        $images = $images->getForAccount($account);
        return $this->ok("Here are your images", $images->serialize());
    }

    public function store(Request $request, ImageContract $images)
    {
        $account = Sopko::get("account");
        $ext = $this->mimeType($request->header('Content-Type'));
        $image = $request->getContent();
        $name = ((string) Str::uuid()) . "_" . time();
        $fullName = "$name.$ext";
        Storage::disk('public')->put($fullName, $image);
        $images->store([], ["path" => $fullName, "account_id" => $account->id]);
        return $this->ok("Successfully uploaded image", [
            "path" => $fullName
        ]);
    }

    public function destroy($image_path, ImageContract $images) 
    {
        $images->checkBelongs(Sopko::get("account"), $image_path);
        $id = Image::where('path', $image_path)->first()->id;
        $images->destroy($id);
        Storage::disk('public')->delete($image_path);
        return $this->ok("Image successfully deleted");
    }   

    // TODO: 404 za content type koji ne postoji
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