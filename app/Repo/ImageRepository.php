<?php

namespace App\Repo;

use App\Models\Image;
use App\Repo\Contracts\ImageContract;
use App\Models\Account;
use App\Repo\DTO\BaseDTO;
use App\Repo\DTO\ImageCollectionDTO;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ImageRepository extends EloquentRepository implements ImageContract
{
    public function model() 
    {
        return Image::class;
    }

    public function getForAccount(Account $account) : ImageCollectionDTO
    {
        $images = $account->images
            ->map(function($image) { return BaseDTO::intoDTO($image); });
        

        return new ImageCollectionDTO($images);
    }

    public function checkBelongs(Account $account, string $image_name_hash)
    {
        if(!Image::where('account_id', $account->id)->where('path', $image_name_hash)->exists()) {
            throw new ModelNotFoundException("The image your looking for is not found");
        }
    }
}