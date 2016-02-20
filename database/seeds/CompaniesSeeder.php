<?php

use Faker\Factory;
use App\Model\Company;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{

    public function run()
    {
        Company::truncate();

        $faker = Factory::create();
        for ($i = 0; $i < 20; $i++) {
            Company::create([
                'title'   => $faker->unique()->company,
                'address' => $faker->streetAddress,
                'phone'   => $faker->phoneNumber,
            ]);
        }
    }

}
