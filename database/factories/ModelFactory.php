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

$factory->define(App\Entity\User::class, function ($faker) {
    return [
        'username'        => $faker->unique()->name,
        'email'           => $faker->unique()->email,
        'email_confirmed' => $faker->randomElement([true, false]),
        'credits'         => $faker->numberBetween(0, 100),
        'password'        => str_random(10),
    ];
});

$factory->defineAs(App\Entity\User::class, 'admin', function ($faker) use ($factory) {
    $user = $factory->raw(App\Entity\User::class);

    $admin = [
        'username'        => 'admin',
        'email'           => 'email@email.com',
        'email_confirmed' => true,
        'credits'         => 100,
        'password'        => '123456',
    ];

    return array_merge($user, $admin);
});

$factory->defineAs(App\Entity\User::class, 'test', function ($faker) {
    return [
        'username'        => $faker->unique()->name,
        'email'           => $faker->unique()->email,
        'email_confirmed' => $faker->randomElement([true, false]),
        'credits'         => 1337,
        'password'        => str_random(10),
    ];
});