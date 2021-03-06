<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Str; 

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name, 
        'price' => Str::random(3),
    ];
});
