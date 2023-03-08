<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Admin',
                'slug' => 'super_admin',
                'status' => 1
            ],
            [
                'name' => 'Ministry Admin',
                'slug' => 'ministry_admin',
                'status' => 1
            ],
            [
                'name' => 'Ministry CAO',
                'slug' => 'ministry_cao',
                'status' => 1
            ],
            [
                'name' => 'Ministry Officer',
                'slug' => 'ministry_officer',
                'status' => 1
            ],
            [
                'name' => 'Ministry Office Admin',
                'slug' => 'mo_admin',
                'status' => 1
            ],
            [
                'name' => 'Ministry Office CAO',
                'slug' => 'mo_cao',
                'status' => 1
            ],
            [
                'name' => 'Ministry Office Officer',
                'slug' => 'mo_officers',
                'status' => 1
            ],
            [
                'name' => 'Local Goverment Admin',
                'slug' => 'lg_admin',
                'status' => 1
            ],
            [
                'name' => 'Local Goverment CAO',
                'slug' => 'lg_cao',
                'status' => 1
            ],
            [
                'name' => 'Local Goverment Officer',
                'slug' => 'lg_officer',
                'status' => 1
            ],
        ];

        \DB::table('roles')->insert($roles);
    }
}
