<?php

namespace App\Console\Commands;

use App\Models\LocalGovernment;
use App\Models\Ministry;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        User::truncate();
        $localGovernments = $this->getLgUsers();
        $ministries = $this->getMinistryUsers();
        $users = array_merge($ministries, $localGovernments);

        $i = 0;
        foreach (array_chunk($users, 1000) as $groupedUsers) {
            foreach ($users as $user) {
                User::create($user);
            }
            echo ++$i."\n";
            //DB::table('users')->insert($groupedUsers);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        $this->info("Users Added");
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

        $i = 0;
        foreach ($localGovernments as $lg) {

            $firstName = $lg->name;
            $lastName = '#';
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
            $emailSlug = $website;

            foreach ($roles as $role) {
                $email = $emailSlug.'.'.$role->slug.'@lgportal.com';
                $users[] = [
                    'first_name'    => $firstName,
                    'last_name'     => $lastName,
                    'email'         => $email,
                    'email_verified_at' => getCurrentDateTime(),
                    'role_id'       => $role->id,
                    'lg_id'         => $lg->id,
                    'ministry_id'   => null,
                    'type'          => 'local_government',
                    'password'      => $password,
                    'remember_token' => $rememberToken
                ];
                echo $i++."\n";
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
                'first_name'        => 'Super',
                'last_name'         => 'Admin',
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

            $firstName = str_replace('Ministry of ', '', $ministry->name);
            $lastName = 'Ministry';
            $nameSlug = Str::slug($firstName);

            foreach ($this->getMinistryRoles() as $role) {
                $email = $nameSlug.'.'.$role->slug.'@lgportal.com';
                $users[] = [
                    'first_name'    => $firstName,
                    'last_name'     => $lastName,
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


    public function filter()
    {
        $lg = new \stdObj();
        $searchString = ' ';
        if (str_contains($lg->name, 'village') || str_contains($lg->name, 'Village')) {
            $searchString = str_contains($lg->name, 'village') ? 'village' : 'Village';
        } else {
            if (str_contains($lg->name, 'Municipality') || str_contains($lg->name, 'municipality')) {
                $searchString = str_contains($lg->name, 'municipality') ? 'municipality' : 'Municipality';
            }
        }
        $name = explode($searchString, $lg->name, 2);
        $firstName = trim($name[0]);
        $lastName = trim(str_replace($firstName, '', $lg->name));
        $emailSlug = Str::slug($firstName);

    }
}
