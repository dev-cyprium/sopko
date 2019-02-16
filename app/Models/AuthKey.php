<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthKey extends Model
{
    public static function boot()
    {
        parent::boot();

        static::creating(function($model) {
            $model->generateHash();
        });
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    protected function generateHash()
    {
        $random_bytes = md5(uniqid(mt_rand(), true));
        $this->hash   = $random_bytes;
    }
}
