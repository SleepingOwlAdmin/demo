<?php

use Faker\Factory;
use App\Model\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{

    public function run()
    {
        News::truncate();
        $faker = Factory::create();
        for ($i = 0; $i < 20; $i++) {
            News::create([
                'title'     => $faker->unique()->sentence(4),
                'date'      => $faker->dateTimeThisCentury,
                'published' => $faker->boolean(),
                'text'      => $faker->paragraph(5),
            ]);
        }
    }

}
