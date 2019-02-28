<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'company_name', 'password_hash', 'telephone_1', 'telephone_2', 'full_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password_hash'
    ];

    /**
     * Gets all of the authorization keys of this account
     */
    public function authKeys()
    {
        return $this->hasMany(AuthKey::class);
    }

    /**
     * Gets all the categories of this account
     */
    public function categories()
    {
        return $this->hasMany(ProductCategory::class);
    }
}
