<?php

use Faker\Factory;
use App\Model\Company;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{

    public function run()
    {

        factory(Company::class, 10)->create();
    }

}
