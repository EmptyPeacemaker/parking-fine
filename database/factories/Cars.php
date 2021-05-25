<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Cars::class, function (Faker $faker) {
    return [
        'user_id'=>0,
        'number'=>$faker->regexify('[A-Z]{2}[0-9]{3}[A-Z]{1}')
    ];
});
