<?php

use App\Permission;
use App\Role;
use App\User;
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
        $adminUser = User::create([
            'name'     => 'admin',
            'email'    => 'admin@site.com',
            'password' => bcrypt('password'),
        ]);

        $testUser = User::create([
            'name'     => 'manager',
            'email'    => 'manager@site.com',
            'password' => bcrypt('password'),
        ]);

        $adminRole = Role::create([
            'name'  => 'admin',
            'display_name' => 'Administrator'
        ]);

        $managerRole = Role::create([
            'name'  => 'manager',
            'display_name' => 'Manager'
        ]);

        $adminUser->roles()->attach($adminRole);
        $adminUser->roles()->attach($managerRole);

        $testUser->roles()->attach($managerRole);
    }
}
