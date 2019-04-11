<?php

use App\User;
use Illuminate\Support\Str;
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
    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'password'       => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\Model\News::class, function (Faker $faker) {
    return [
        'title'     => $faker->unique()->sentence(4),
        'date'      => $faker->dateTimeThisCentury,
        'published' => $faker->boolean(),
        'text'      => $faker->paragraph(5),
    ];
});
$factory->define(App\Model\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(5),
        'text'  => $faker->paragraph(5),
    ];
});
$factory->define(App\Model\Page::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(5),
        'text'  => $faker->paragraph(5),
    ];
});
$factory->define(App\Model\Company::class, function (Faker $faker) {
    return [
        'title'   => $faker->unique()->company,
        'address' => $faker->streetAddress,
        'phone'   => $faker->phoneNumber,
    ];
});
$factory->define(App\Model\Country::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->country,
    ];
});
$factory->define(App\Model\Forms\Form::class, function (Faker $faker) {
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
$factory->define(App\Model\Contact::class, function (Faker $faker) {
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
