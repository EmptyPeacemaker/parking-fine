<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Fine::class, function (Faker $faker) {
    $adr=['ул. Большая Шерстомойная, 40 корпус 1','ул. Адмирала Макарова, 5'];
    return [
        'car_id'=>0,
        'text'=>$faker->text(),
        'adr'=>$adr[rand(0,1)],
        'price'=>$faker->numberBetween(1000,9999)
    ];
});
