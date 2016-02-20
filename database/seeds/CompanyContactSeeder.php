<?php

use App\Model\Company;
use App\Model\Contact;
use Illuminate\Database\Seeder;

class CompanyContactSeeder extends Seeder
{

    public function run()
    {
        $contacts  = Contact::all();
        $companies = Company::all();

        for ($i = 0; $i < 20; $i++) {
            try {
                $contacts->random()->companies()->attach($companies->random());
            } catch (\Exception $e) {
            }
        }
    }

}
