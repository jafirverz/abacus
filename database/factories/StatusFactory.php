<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Model;
use App\Status;

$factory->define(Status::class, function (Faker $faker) {
    return [
        'title' => $faker->catchPhrase,
    ];
});
