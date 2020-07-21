<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Achievement;
use Faker\Generator as Faker;

$factory->define(Achievement::class, function (Faker $faker) {
    return [
        'title' => $faker->words(2,true),
        'description' => $faker->realText($maxNbChars = 200, $indexSize = 2),
        'points' => $faker->randomDigit
    ];
});
