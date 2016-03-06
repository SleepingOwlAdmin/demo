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
        DB::table('role_user')->truncate();
        Permission::truncate();

        $adminUser = User::create([
            'name'     => 'admin',
            'email'    => 'admin@site.com',
            'password' => 'password',
        ]);

        $testUser = User::create([
            'name'     => 'manager',
            'email'    => 'manager@site.com',
            'password' => 'password',
        ]);

        $adminRole = Role::create([
            'name'  => 'admin',
            'label' => 'Administrator'
        ]);

        $managerRole = Role::create([
            'name'  => 'manager',
            'label' => 'Manager'
        ]);

        $adminUser->roles()->attach($adminRole);
        $adminUser->roles()->attach($managerRole);

        $testUser->roles()->attach($managerRole);
    }
}
