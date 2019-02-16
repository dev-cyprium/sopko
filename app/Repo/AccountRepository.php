<?php

namespace App\Repo;

use App\Repo\EloquentRepository;
use App\Models\Account;

class AccountRepository extends EloquentRepository
{
    function model()
    {
        return Account::class;
    }
}