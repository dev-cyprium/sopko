<?php

namespace App\Http\Controllers;

use App\Repo\AccountRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends ApiController
{
    protected $repo;

    public function __construct(AccountRepository $repo)
    {
        $this->repo = $repo;
    }

    public function store(Request $request)
    {
        $request->validate($this->validateCondition());
        $with_crypt = array_merge($request->all(), ['password_hash' => Hash::make($request['password'])]);
        $this->repo->store($with_crypt);
        return $this->ok("Successfully registered an user");
    }

    private function validateCondition() 
    {
        return [
            'company_name' => 'required|max:100',
            'email'        => 'required|email|unique:accounts,email|max:50',
            'password'     => 'required|min:6'
        ];
    }
}