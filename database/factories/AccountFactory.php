<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\Account::class, function (Faker $faker) {
    return [
        'company_name' => $faker->company,
        'email' => $faker->unique()->safeEmail,
        'full_name' => $faker->name,
        'password_hash' => '$2y$10$ndb6druVK85hjixMGW5L.uzsn.wceouxUy1wnnrYPcLoxv69QkLq6', // secret
    ];
});
