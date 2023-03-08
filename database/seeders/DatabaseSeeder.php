<?php

namespace Database\Seeders;

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
        $this->call([
            MinistrySeeder::class,
            PermissionTableSeeder::class,
            RoleTableSeeder::class,
            RolePermissionPivotTableSeeder::class,
            UserTableSeeder::class,
            MinistryOffice::class,
            MinistryOfficeUser::class
        ]);
    }
}
