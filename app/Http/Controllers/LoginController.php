<?php

namespace App\Http\Controllers;

use App\Repo\Contracts\AccountContract;
use Illuminate\Http\Request;

class LoginController extends ApiController
{
    /// TODO extend FormRequest for validation
    public function login(Request $request, AccountContract $accountProvider)
    {
        $request->validate([
           'email' => 'required',
           'password' => 'required'
        ]);

        $email    = $request['email'];
        $password = $request['password'];

        if($accountProvider->checkCredentials($email, $password, $foundAccount)) {
            return $this->ok("Successfuly authorized user", $foundAccount->serialize());
        }

        return $this->forbidden("Invalid email or password");
    }
}