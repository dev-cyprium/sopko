<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Storage::class, function (Faker $faker) {
    return [
        'address' => $faker->address,
        'name'    => $faker->name,
        'geo_lat' => $faker->latitude,
        'geo_lon' => $faker->longitude
    ];
});
