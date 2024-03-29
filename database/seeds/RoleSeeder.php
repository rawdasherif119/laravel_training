<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Role::insert([
            [
                'name' => 'Admin',
                'description' => 'Administrator',
            ],
            [
                'name' => 'staff',
                'description' => 'staff',
            ]
        ]);
    }
}
