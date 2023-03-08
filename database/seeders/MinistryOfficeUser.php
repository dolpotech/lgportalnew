<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MinistryOfficeUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'          => Str::random(10),
            'address'       => Str::random(10),
            'email'         => Str::random(10).'@gmail.com',
            'password'      => Hash::make('12345678'),
            'type'          => 'ministry_office',
            'status'        => 1,
            'lg_id'         => null,
            'ministry_id'   => 1,
            'office_id'     => 1,
            'phone_no'      => 9876543210,
        ]);
        $user->roles()->sync(5);
        $user2= User::create([
            'name'          => Str::random(10),
            'address'       => Str::random(10),
            'email'         => Str::random(10).'@gmail.com',
            'password'      => Hash::make('12345678'),
            'type'          => 'ministry_office',
            'status'        => 1,
            'lg_id'         => null,
            'ministry_id'   => 2,
            'office_id'     => 2,
            'phone_no'      => 9876543210,
        ]);
        $user2->roles()->sync(5);
        $user3= User::create([
            'name'          => Str::random(10),
            'address'       => Str::random(10),
            'email'         => Str::random(10).'@gmail.com',
            'password'      => Hash::make('12345678'),
            'type'          => 'ministry_office',
            'status'        => 1,
            'lg_id'         => null,
            'ministry_id'   => 3,
            'office_id'     => 3,
            'phone_no'      => 9876543210,
        ]);
        $user3->roles()->sync(5);
        $user4= User::create([
            'name'          => Str::random(10),
            'address'       => Str::random(10),
            'email'         => Str::random(10).'@gmail.com',
            'password'      => Hash::make('12345678'),
            'type'          => 'ministry_office',
            'status'        => 1,
            'lg_id'         => null,
            'ministry_id'   => 4,
            'office_id'     => 4,
            'phone_no'      => 9876543210,
        ]);
        $user4->roles()->sync(5);
        $user5= User::create([
            'name'          => Str::random(10),
            'address'       => Str::random(10),
            'email'         => Str::random(10).'@gmail.com',
            'password'      => Hash::make('12345678'),
            'type'          => 'ministry_office',
            'status'        => 1,
            'lg_id'         => null,
            'ministry_id'   => 5,
            'office_id'     => 5,
            'phone_no'      => 9876543210,
        ]);
        $user5->roles()->sync(5);
    }
}
