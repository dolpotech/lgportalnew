<?php

namespace Database\Seeders;

use App\Models\LocalGovernment;
use App\Models\Ministry;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $localGovernments = $this->getLgUsers();
        $ministries = $this->getMinistryUsers();
        $users = array_merge($ministries, $localGovernments);

        $i = 0;
        $userRoles = [];
        foreach ($users as $user) {
            $roleId = $user['role_id'];
            unset($user['role_id']);
            $newUser = User::create($user);
            $userRoles[] = [
                'user_id' => $newUser->id,
                'role_id' => $roleId,
            ];
        }
        foreach (array_chunk($userRoles, 1000) as $userGroupRoles) {
            DB::table('user_roles')->insert($userGroupRoles);
        }
    }



    /**
     * Get Lg Users
     *
     * @return array
     */
    public function getLgUsers(): array
    {
        $users = [];

        $localGovernments = $this->getLocalGovernments();
        $roles = $this->getLgRoles();
        $password = bcrypt(12345678);
        $rememberToken = Str::random(10);

        foreach ($localGovernments as $lg) {

            $name = $lg->name;
            $website = parse_url($lg->website);
            if (count($website) == 0 || !isset($website['host'])) {
                $website = Str::slug($lg->name);
            } else {
                $website = $website['host'];
                $website = substr($website, 0, strpos($website, "."));
                if ($website == '') {
                    $website = Str::slug($lg->name);
                }
            }
            $emailSlug = $website.'_'.$lg->id;

            foreach ($roles as $role) {
                $email = $emailSlug.'.'.$role->slug.'@lgportal.com';
                $users[] = [
                    'name'          => $name,
                    'email'         => $email,
                    'email_verified_at' => getCurrentDateTime(),
                    'role_id'       => $role->id,
                    'lg_id'         => $lg->id,
                    'ministry_id'   => null,
                    'type'          => 'local_government',
                    'password'      => $password,
                    'remember_token' => $rememberToken
                ];
            }
        }

        return $users;
    }



    public function getMinistryUsers(): array
    {
        $password = bcrypt(12345678);
        $rememberToken = Str::random(10);
        $users = [
            [
                'name'              => 'Super Admin',
                'email'             => 'super.admin@lgportal.com',
                'email_verified_at' => now(),
                'role_id'           => 1,
                'lg_id'             => null,
                'ministry_id'       => null,
                'type'              => 'local_government',
                'password'          => $password,
                'remember_token'    => $rememberToken
            ]
        ];

        foreach ($this->getMinistries() as $ministry) {

            $name = $ministry->name;
            $emailSlug = $ministry->email;

            foreach ($this->getMinistryRoles() as $role) {
                $email = $role->slug.'.'.$emailSlug;
                $users[] = [
                    'name'          => $name,
                    'email'         => $email,
                    'email_verified_at' => getCurrentDateTime(),
                    'role_id'       => $role->id,
                    'lg_id'         => null,
                    'ministry_id'   => $ministry->id,
                    'type'          => 'ministry',
                    'password'      => $password,
                    'remember_token' => $rememberToken
                ];
            }
        }

        return $users;
    }



    /**
     * Get Ministries
     *
     * @return mixed
     */
    public function getMinistries()
    {
        return Ministry::all();
    }


    /**
     * Get Local Governments
     *
     * @return mixed
     */
    public function getLocalGovernments()
    {
        return LocalGovernment::all();
    }


    /**
     * Ministry Roles
     *
     * @return mixed
     */
    public function getMinistryRoles()
    {
        return Role::whereIn('slug', getMinistryRoles())->get();
    }


    /**
     * Lg Roles
     *
     * @return mixed
     */
    public function getLgRoles()
    {
        return Role::whereIn('slug', getLgRoles())->get();
    }


}
