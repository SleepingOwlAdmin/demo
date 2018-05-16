<?php

use Illuminate\Database\Seeder;

class SomeModelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('some_models')->insert([
            ['language_id' => 1, 'name' => 'Name']
        ]);

        DB::table('some_another_models')->insert([
            ['language_id' => 1, 'name' => 'Name'],
            ['language_id' => 1, 'name' => 'Name 1'],
            ['language_id' => 1, 'name' => 'Name 2']
        ]);
    }
}
