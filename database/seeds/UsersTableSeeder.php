<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::truncate();

        DB::table('users')->insert([
            'name'     => 'admin',
            'email'    => 'admin@site.com',
            'password' => bcrypt('password'),
        ]);
    }
}
