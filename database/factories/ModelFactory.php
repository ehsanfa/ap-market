<?php

use App\Models\User;
use App\Models\Store;
use App\Models\Product;

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

$factory->define(User::class, function (Faker\Generator $faker) {
	$roles = ['customer', 'seller'];
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => password_hash('secret', PASSWORD_DEFAULT),
        'location_lat' => 35+rand(1, 100000)/100000,
        'location_long' => 51+rand(1, 100000)/100000,
        'role' => $roles[rand(1,2)]
    ];
});

$factory->define(Store::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->name,
        'user_id' => User::inRandomOrder()->first()->id,
        'location_lat' => 35+rand(1, 100000)/100000,
        'location_long' => 51+rand(1, 100000)/100000,
        'role' => $roles[rand(1,2)]
    ];
});

$factory->define(Product::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->name,
        'store_id' => Store::inRandomOrder()->first()->id,
        'price' => rand(10000, 1000000),
        'quantity' => rand(1, 100)
    ];
});
