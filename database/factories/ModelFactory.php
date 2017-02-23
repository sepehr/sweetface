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
$factory->define(SweetFace\User::class, function (Faker\Generator $faker) {
    return [
        'name'     => $faker->name,
        'fb_id'    => str_random(17),
        'fb_token' => str_random(179),
        'avatar'   => 'https://fbcdn-profile-a.akamaihd.net/static-ak/rsrc.php/v2/yL/r/HsTZSDw4avx.gif',
    ];
});
