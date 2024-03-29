<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountriesTableSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(AdminUserSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(JobsTableSeeder::class);
        $this->call(FoldersSeeder::class);


    }
}
