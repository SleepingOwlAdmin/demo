<?php

use Faker\Factory;
use App\Model\Page;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{

    public function run()
    {
        Page::truncate();

        $pages = factory(Page::class, 100)->create();

        $pages->each(function(Page $page) use($pages) {
            $childPage = $pages->random();

            try {
                $page->makeChildOf($childPage);
            } catch (\Exception $e) {}
        });
    }

}
