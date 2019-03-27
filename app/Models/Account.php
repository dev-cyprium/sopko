<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
     * We need to create a unique salt when making a model
     * for a company
     */
    public static function boot()
    {
        parent::boot();
        static::creating(function($model) {
            $model->salt = uniqid("", true);
        });
    }

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

    /**
     * Get all the images that belong to this account
     */
    public function images() 
    {
        return $this->hasMany(Image::class);
    }
}
