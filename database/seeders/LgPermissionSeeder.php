<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LgPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions=[
            [
              "name"=> 'create users',
              "slug" =>'create_user',
                "status"=>1
            ],
            [
                "name"=>'detail status viewer',
                "slug"=>'detail_status_viewer',
                "status"=>1

            ],
            [
                "name"=>'Information Approver',
                "slug"=>'information_approver',
                "status"=>1

            ],
            [
                "name"=>'uploads data and docments',
                "slug"=>'data_and document_uploader',
                "status"=>1
            ],
            [
                "name"=>'information provider',
                "slug"=>'information_provider',
                "status"=>1

            ]
        ];
        foreach($permissions as $permission){
            DB::table('lg_permissions')->insert([
                'name' => $permission['name'],
                 'slug'=>$permission['slug'],
                 'status'=>$permission['status']
            ]);
        }
    }
}
