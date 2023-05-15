<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Admin;
use Faker\Generator as Faker;
use App\Model;
use Illuminate\Support\Str;

$factory->define(Admin::class, function (Faker $faker) {
    return [
        // 'firstname' => $faker->firstName,
        // 'lastname' => $faker->lastName,
        // 'email' => $faker->unique()->safeEmail,
        // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        // 'admin_role' => 6,
        // 'status' => 1,
        // 'remember_token' => Str::random(10),
    ];
});
