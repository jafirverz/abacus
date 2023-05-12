<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Location;
use Faker\Generator as Faker;
use App\Model;

$factory->define(Location::class, function (Faker $faker) {
    return [
        'title' => $faker->country,
    ];
});
