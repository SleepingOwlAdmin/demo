<?php

use App\Model\Company;
use App\Model\Contact;
use Illuminate\Database\Seeder;

class CompanyContactSeeder extends Seeder
{

    public function run()
    {
        /** @var Contact[] $contacts */
        $contacts  = Contact::all();
        /** @var Company[] $companies */
        $companies = Company::all();

        for ($i = 0; $i < 5; $i++) {
            try {
                $contacts->random()->companies()->attach($companies->random());
            } catch (\Exception $e) {
            }
        }
    }

}
