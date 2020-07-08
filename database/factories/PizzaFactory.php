<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'customer_name' => $faker->text(15),
        'type' => $faker->text(20),
        'crust' => $faker->text(10)
    ];
});
