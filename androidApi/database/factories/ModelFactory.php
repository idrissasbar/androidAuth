<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(30),
    ];
});


$factory->define(App\Child::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'birthdate' => $faker->date,
        'user_id' => $faker->numberBetween(\DB::table('users')->min('id'), \DB::table('users')->max('id')),
    ];
});


