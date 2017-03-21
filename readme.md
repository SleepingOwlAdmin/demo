## SleepingOwl Admin Demo Application

[![Build Status](https://travis-ci.org/SleepingOwlAdmin/demo.svg?branch=master)](https://travis-ci.org/SleepingOwlAdmin/demo)

This is demo application for [SleepingOwl Admin](https://github.com/LaravelRUS/SleepingOwlAdmin).

You can watch live http://demo.sleepingowladmin.ru/admin

**Login**: admin@site.com
**Password**: password

* After cloning the repository run `composer install`
* Create `.env` file from `.env.example`
* Run `composer update`
* Run `php artisan key:generate`
* Configure database connection
* Run `php artisan migrate --seed`

Enjoy!

## Documentation

Documentation can be found in the [SleepingOwl Admin documentation](http://sleepingowl.laravel.su/docs/4.0/).

### License

The SleepingOwl Admin demo application is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
