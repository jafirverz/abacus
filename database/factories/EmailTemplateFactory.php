<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\EmailTemplate;
use Faker\Generator as Faker;
use App\Model;

$factory->define(EmailTemplate::class, function (Faker $faker) {
    return [
        'title' => $faker->catchPhrase,
        'subject' => $faker->catchPhrase,
        'content' => $faker->text($maxNbChars = 200),
        'view_order' => 0,
        'status' => 1,
    ];
});
