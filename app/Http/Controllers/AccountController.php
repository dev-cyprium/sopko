<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Repo\AccountRepository;

class AccountController extends Controller
{
    public function index(AccountRepository $repo)
    {
        return $repo->getAll();
    }
}