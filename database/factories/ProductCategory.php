<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ProductCategory::class, function (Faker $faker) {
    return [
        "title" => $faker->word,
    ];
});
