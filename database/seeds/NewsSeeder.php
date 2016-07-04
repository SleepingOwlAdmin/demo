<?php

use Faker\Factory;
use App\Model\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{

    public function run()
    {
        News::truncate();

        factory(News::class, 50)->create();
    }

}
