<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Parking;
use Faker\Generator as Faker;

$factory->define(Parking::class, function (Faker $faker) {
    return [
        'car_id'=>0,
        'create'=>$faker->dateTimeBetween('-5 hour','+5 hour')
    ];
});
