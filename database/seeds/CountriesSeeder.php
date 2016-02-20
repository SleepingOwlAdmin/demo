<?php

use Faker\Factory;
use App\Model\Contact;
use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{

    public function run()
    {
        Contact::truncate();
        $faker = Factory::create();
        for ($i = 0; $i < 20; $i++) {
            Contact::create([
                'title' => $faker->unique()->country,
            ]);
        }
    }

}
