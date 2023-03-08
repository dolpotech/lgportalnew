<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MinistryOffice extends Seeder
{
    public function run()
    {
        DB::table('ministry_offices')->insert([
            'ministry_id' => 1,
            'name' => Str::random(10),
            'name_en'=>Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'phone_no' => 9876543210,
            'address'=>Str::random(10),
            'status'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);
        DB::table('ministry_offices')->insert([
            'ministry_id' => 2,
            'name' => Str::random(10),
            'name_en'=>Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'phone_no' => 9876543210,
            'address'=>Str::random(10),
            'status'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);
        DB::table('ministry_offices')->insert([
            'ministry_id' => 3,
            'name' => Str::random(10),
            'name_en'=>Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'phone_no' => 9876543210,
            'address'=>Str::random(10),
            'status'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);
        DB::table('ministry_offices')->insert([
            'ministry_id' => 4,
            'name' => Str::random(10),
            'name_en'=>Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'phone_no' => 9876543210,
            'address'=>Str::random(10),
            'status'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);
        DB::table('ministry_offices')->insert([
            'ministry_id' => 5,
            'name' => Str::random(10),
            'name_en'=>Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'phone_no' => 9876543210,
            'address'=>Str::random(10),
            'status'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);
        DB::table('ministry_offices')->insert([
            'ministry_id' => 6,
            'name' => Str::random(10),
            'name_en'=>Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'phone_no' => 9876543210,
            'address'=>Str::random(10),
            'status'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);
        DB::table('ministry_offices')->insert([
            'ministry_id' => 7,
            'name' => Str::random(10),
            'name_en'=>Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'phone_no' => 9876543210,
            'address'=>Str::random(10),
            'status'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);
        DB::table('ministry_offices')->insert([
            'ministry_id' => 8,
            'name' => Str::random(10),
            'name_en'=>Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'phone_no' => 9876543210,
            'address'=>Str::random(10),
            'status'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);
        DB::table('ministry_offices')->insert([
            'ministry_id' => 9,
            'name' => Str::random(10),
            'name_en'=>Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'phone_no' => 9876543210,
            'address'=>Str::random(10),
            'status'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);
        DB::table('ministry_offices')->insert([
            'ministry_id' => 10,
            'name' => Str::random(10),
            'name_en'=>Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'phone_no' => 9876543210,
            'address'=>Str::random(10),
            'status'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);
        DB::table('ministry_offices')->insert([
            'ministry_id' => 11,
            'name' => Str::random(10),
            'name_en'=>Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'phone_no' => 9876543210,
            'address'=>Str::random(10),
            'status'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);
        DB::table('ministry_offices')->insert([
            'ministry_id' => 12,
            'name' => Str::random(10),
            'name_en'=>Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'phone_no' => 9876543210,
            'address'=>Str::random(10),
            'status'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);
        DB::table('ministry_offices')->insert([
            'ministry_id' => 13,
            'name' => Str::random(10),
            'name_en'=>Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'phone_no' => 9876543210,
            'address'=>Str::random(10),
            'status'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ]);




    }
}
