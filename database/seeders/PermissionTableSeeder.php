<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'show_permission',
                'slug' => 'show_permission',
                'status' => 1
            ],
            [
                'name' => 'update_permission',
                'slug' => 'update_permission',
                'status' => 1
            ],
            [
                'name' => 'delete_permission',
                'slug' => 'delete_permission',
                'status' => 1
            ]
        ];
        \DB::table('permissions')->insert($permissions);
    }
}
