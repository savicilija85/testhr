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
    static $password;

    return [
        'name' => $faker->name,
        'username' => $faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,
        'password' => $password ?: $password = bcrypt('123456'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Account::class, function (Faker $faker) {

    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 50),
        'account_no' => $faker->bankAccountNumber,
        ];
});

$factory->define(App\Admin::class, function (Faker $faker){
    static $password;

    return [
      'username' => 'admin',
      'password' => $password ?: $password = bcrypt('123456'),
   ] ;
});
