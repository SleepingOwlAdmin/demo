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
        User::truncate();
        Role::truncate();
        Permission::truncate();

        $adminUser = User::create([
            'name'     => 'admin',
            'email'    => 'admin@site.com',
            'password' => bcrypt('password'),
        ]);

        $testUser = User::create([
            'name'     => 'test',
            'email'    => 'test@site.com',
            'password' => bcrypt('password'),
        ]);

        $adminRole = Role::create([
            'name' => 'admin',
            'label' => 'Administrator'
        ]);

        $managerRole = Role::create([
            'name' => 'manager',
            'label' => 'Manager'
        ]);

        $adminUser->roles()->attach($adminRole);
        $adminUser->roles()->attach($managerRole);

        $testUser->roles()->attach($managerRole);
    }
}
