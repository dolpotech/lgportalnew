<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionPivotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_permission = [
            [
                'role_id' => 1,
                'permission_id' => 1,
            ],
            [
                'role_id' => 1,
                'permission_id' => 2,
            ],
            [
                'role_id' => 2,
                'permission_id' => 2,
            ]
        ];
        DB::table('role_permission')->insert($role_permission);
    }
}
