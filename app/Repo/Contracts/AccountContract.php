<?php

namespace App\Repo\Contracts;

interface AccountContract extends Repository
{
  public function checkCredentials(string $email, string $password, &$account) : bool;
}