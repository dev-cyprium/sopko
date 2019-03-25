<?php

namespace App\Http\Controllers;

use App\Repo\AccountRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Repo\DTO\BaseDTO;

class AccountController extends ApiController
{
    protected $repo;

    // TODO: change to contract instead of repositoy
    public function __construct(AccountRepository $repo)
    {
        $this->repo = $repo;
    }

    public function store(Request $request)
    {
        $request->validate($this->validateCondition());
        $with_crypt = array_merge($request->all(), ['password_hash' => Hash::make($request['password'])]);
        $user = $this->repo->store($with_crypt);
        return $this->ok("Successfully registered an user", $user->serialize());
    }

    private function validateCondition() 
    {
        return [
            'company_name' => 'required|max:100',
            'full_name'    => 'required',
            'email'        => 'required|email|unique:accounts,email|max:50',
            'password'     => 'required|min:6'
        ];
    }
}