<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MinistryOfficeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ministry_offices')->insert([
            'ministry_id' => 1,
            'name' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'phone_no' => 12345678,
        ]);
        DB::table('ministry_offices')->insert([
            'ministry_id' => 2,
            'name' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'phone_no' => 12345678,
        ]);

        $user = User::create([
            'name'          => Str::random(10),
            'address'       => Str::random(10),
            'email'         => Str::random(10).'@gmail.com',
            'password'      => Hash::make('12345678'),
            'type'          => 'ministry_office',
            'status'        => 1,
            'lg_id'         => null,
            'ministry_id'   => null,
            'office_id'     => 1,
            'phone_no'      => 12345678,
        ]);
        $user->roles()->sync(5);


    }
}
