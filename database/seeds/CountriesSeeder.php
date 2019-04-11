<?php

use Faker\Factory;
use App\Model\Country;
use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{

    public function run()
    {
        factory(Country::class, 30)->create();
    }

}
