<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    $password = "$2y$10$.f2uGvoHhWxjebKN9.HpgeH495pOajNGWxOoSX6lRn4ZRaR3DG0xG";

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password,
        'remember_token' => str_random(10),
    ];
});
