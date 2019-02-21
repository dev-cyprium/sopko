<?php

namespace App\Repo;

use App\Repo\Contracts\AccountContract;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;

class AccountRepository extends EloquentRepository implements AccountContract
{
    function model()
    {
        return Account::class;
    }

    public function checkCredentials(string $email, string $givenPassword) : bool
    {
        $possibleAccount = Account::where("email", $email)->first();

        if($possibleAccount) {
            if(Hash::check($givenPassword, $possibleAccount->password_hash)) {
                return true;
            }
        }

        return false;
    }
}