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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'password'       => str_random(10),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Model\News::class, function (Faker\Generator $faker) {
    return [
        'title'     => $faker->unique()->sentence(4),
        'date'      => $faker->dateTimeThisCentury,
        'published' => $faker->boolean(),
        'text'      => $faker->paragraph(5),
    ];
});

$factory->define(App\Model\Post::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(5),
        'text'  => $faker->paragraph(5),
    ];
});

$factory->define(App\Model\Page::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(5),
        'text'  => $faker->paragraph(5),
    ];
});

$factory->define(App\Model\Company::class, function (Faker\Generator $faker) {
    return [
        'title'   => $faker->unique()->company,
        'address' => $faker->streetAddress,
        'phone'   => $faker->phoneNumber,
    ];
});

$factory->define(App\Model\Country::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->unique()->country,
    ];
});

$factory->define(App\Model\Forms\Form::class, function (Faker\Generator $faker) {
    return [
        'title'     => $faker->sentence(4),
        'textaddon' => $faker->sentence(2),
        'checkbox'  => $faker->boolean(),
        'date'      => $faker->date(),
        'time'      => $faker->time(),
        'timestamp' => $faker->dateTime,
        'select'    => $faker->optional()->randomElement([1, 2, 3]),
        'textarea'  => $faker->paragraph(5),
        'ckeditor'  => $faker->paragraph(5),
    ];
});

$factory->define(App\Model\Contact::class, function (Faker\Generator $faker) {
    return [
        'firstName'  => $faker->firstName,
        'lastName'   => $faker->lastName,
        'birthday'   => $faker->dateTimeThisCentury,
        'phone'      => $faker->phoneNumber,
        'address'    => $faker->address,
        'comment'    => $faker->paragraph(5),
        'height'     => $faker->randomNumber(2, true) + 100
    ];
});