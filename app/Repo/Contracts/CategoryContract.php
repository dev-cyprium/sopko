<?php

namespace App\Repo\Contracts;

use App\Models\Account;
use App\Repo\DTO\CategoryCollectionDTO;

interface CategoryContract extends Repository 
{
    public function fetchAccountCategories(Account $account) : CategoryCollectionDTO;
}