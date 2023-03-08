<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LgRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles=["Admin", "CAO", "Information Officer"];

        $modified_roles = array_map(function ($role) {
            return [
                'name' => $role,
                'status' => 1,
            ];
        }, $roles);

        DB::table('lg_roles')->insert($modified_roles);
    }
}
