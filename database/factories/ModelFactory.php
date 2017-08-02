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
$factory->define(Podium\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Podium\Podcast::class, function (Faker\Generator $faker) {
    return [
        'title'       => ucwords($faker->unique()->words(3, true)),
        'subtitle'    => ucwords($faker->words(7, true)),
        'description' => $faker->sentences(3, true),
        'language'    => $faker->randomElement(['en', 'de', 'es', 'fr']),
        'is_explicit'    => $faker->boolean(30),
        'publish_at'  => $faker->boolean(50) ? $faker->dateTimeBetween('-30 days', '+30 days') : null,
        'author' => $faker->name,
        'author_email' => $faker->safeEmail,
        // 'user_id'     => factory(Podium\User::class)->create()->first()->id,
    ];
});

$factory->state(Podium\Podcast::class, 'published', function (Faker\Generator $faker) {
    return [
        'publish_at' => $faker->dateTimeBetween('-10 days', '-1 day'),
    ];
});

$factory->state(Podium\Podcast::class, 'unpublished', function (Faker\Generator $faker) {
    return [
        'publish_at' => null,
    ];
});

$factory->state(Podium\Podcast::class, 'explicit', function (Faker\Generator $faker) {
    return [
        'is_explicit' => true,
    ];
});

$factory->state(Podium\Podcast::class, 'clean', function (Faker\Generator $faker) {
    return [
        'is_explicit' => false,
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Podium\Episode::class, function (Faker\Generator $faker) {
    return [
        'title'       => ucwords($faker->unique()->words(3, true)),
        'subtitle'    => ucwords($faker->words(7, true)),
        'description' => $faker->sentences(3, true),
        'explicit'    => $faker->boolean(30),
        'publish_at'  => $faker->boolean(90) ? $faker->dateTimeBetween('-30 days', '+30 days') : null,
    ];
});
