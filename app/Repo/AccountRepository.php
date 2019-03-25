<?php

namespace App\Repo;

use App\Repo\Contracts\AccountContract;
use App\Models\Account;
use Illuminate\Support\Facades\Hash;
use App\Repo\DTO\AccountDTO;
use Illuminate\Auth\Events\Registered;
use App\Repo\DTO\BaseDTO;

class AccountRepository extends EloquentRepository implements AccountContract
{
    function model()
    {
        return Account::class;
    }

    protected function afterStore()
    {
        $this->model->authKeys()->create();
    }

    public function checkCredentials(string $email, string $givenPassword, &$accountDTO) : bool
    {
        $possibleAccount = Account::where("email", $email)->first();

        if($possibleAccount) {
            if(Hash::check($givenPassword, $possibleAccount->password_hash)) {
                $key = $possibleAccount
                    ->authKeys() // #TODO add ->where('valid')
                    ->orderBy('created_at', 'desc')
                    ->first();
                    // TODO: don't assign keys by each value, do mass assignemt
                $accountDTO = new AccountDTO();
                $accountDTO->apiKey   = $key->hash;
                $accountDTO->fullName = $possibleAccount->full_name; 
                return true;
            }
        }

        return false;
    }
}