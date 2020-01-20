<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Camp;
use Faker\Generator as Faker;

$factory->define(Camp::class, function (Faker $faker) {
    // 'location', 'entries', 'cost', 'date'
    return [
        'location'  =>  $faker->address,
        'entries'   =>  $faker->numberBetween($min = 10, $max = 50),
        'cost'      =>  $faker->numberBetween($min = 1000, $max = 9000),
        'date'      =>  $faker->dateTimeBetween('-1 years', 'now')
    ];
});
