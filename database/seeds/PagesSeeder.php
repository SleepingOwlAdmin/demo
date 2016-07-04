<?php

use Faker\Factory;
use App\Model\Page;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{

    public function run()
    {
        Page::truncate();

        factory(Page::class, 20)->create();
    }

}
