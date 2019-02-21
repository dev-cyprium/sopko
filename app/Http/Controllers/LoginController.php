<?php

namespace App\Http\Controllers;

use App\Repo\Contracts\AccountContract;
use Illuminate\Http\Request;

class LoginController extends ApiController
{
    public function login(Request $request, AccountContract $accountProvider)
    {
        $request->validate([
           'email' => 'required',
           'password' => 'required'
        ]);

        $email    = $request['email'];
        $password = $request['password'];

        if($accountProvider->checkCredentials($email, $password)) {
            return $this->ok("Successfuly authorized user", ["apikey" => "xxxxx-xxx-xxx-xxx"]);
        }

        return $this->forbidden("Invalid email or password");
    }
}