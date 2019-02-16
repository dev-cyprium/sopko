<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;

class Account
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'company_name', 'password_hash'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password_hash'
    ];
}
