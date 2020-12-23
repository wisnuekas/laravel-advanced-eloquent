<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Mitra;
use Faker\Generator as Faker;

$factory->define(Mitra::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'firebase_uid' => $faker->asciify('********************'),
    ];
});
