<?php

namespace App\Repo\Contracts;

use App\Models\Account;
use App\Repo\DTO\ImageCollectionDTO;

interface ImageContract extends Repository 
{
    public function getForAccount(Account $account) : ImageCollectionDTO;

    /**
     * Check if the give image belongs to the account
     * If not, it throws an excption
     */
    public function checkBelongs(Account $account, string $image_name_hash);
}