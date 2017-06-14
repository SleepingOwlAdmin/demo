## SleepingOwl Admin Demo Application

[![Build Status](https://travis-ci.org/SleepingOwlAdmin/demo.svg?branch=master)](https://travis-ci.org/SleepingOwlAdmin/demo)

This is demo application for [SleepingOwl Admin](https://github.com/LaravelRUS/SleepingOwlAdmin).

You can watch live http://demo.sleepingowladmin.ru/admin

**Login**: admin@site.com
**Password**: password

Enjoy!

## How to install with (Openserver, WAMP, MAMP, LAMP, Vertigo or something else)

* After cloning the repository run `composer install`
* Create `.env` file from `.env.example` and replace database and other data to you inside
* Run `composer update`
* Run `php artisan key:generate`
* Run `php artisan migrate --seed`

Enjoy!

## How to install with Docker
* Install docker & docker-compose
* After cloning the repository run `docker-compose up -d`
* Put `your-docker-ip demo.soa.com` into your hosts file
* Run `php artisan migrate --seed`
Enjoy!

## Documentation

Documentation can be found in the [SleepingOwl Admin documentation](http://sleepingowl.laravel.su/docs/4.0/).

### License

The SleepingOwl Admin demo application is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
