<?php

use App\Product;
use Faker\Generator as Faker;

$factory->define(
    Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'image_url' => $faker->imageUrl(),
        'dimensions' => [
            'weight' => $faker->randomFloat(),
            'length' => $faker->randomFloat(),
            'width' => $faker->randomFloat(),
        ],
        'quantity' => $faker->numberBetween(0, 500),
    ];
});
