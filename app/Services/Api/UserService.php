<?php


namespace App\Services\Api;


use App\HelperClasses\Traits\AppHelper;
use App\HelperClasses\Traits\AuthHelper;
use App\Models\LocalGovernment;
use App\Models\Ministry;
use App\Models\MinistryOffices;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    use AppHelper, AuthHelper;


    /**
     * Create Minister User
     *
     * @param string $firstName
     * @param string $address
     * @param string $email
     * @param string $password
     * @param string $userType
     * @param int $roleId
     * @param int $status
     * @param int $ministryId
     * @param $officeId
     * @param string $phoneNo
     * @return void
     */
    public function createMinisterUser(string $firstName, string $address, string $email, string $password, string $userType, int $roleId, int $status, int $ministryId ,$officeId,string $phoneNo)
    {
        $user = User::create([
            'name'                  => $firstName,
            'address'               => $address,
            'email'                 => $email,
            'password'              => bcrypt($password),
            'type'                  => $userType,
            'status'                => $status,
            'ministry_id'           => $ministryId,
            'lg_id'                 => null,
            'office_id'             => isset($officeId) ? $officeId ?? '' : null,
            'phone_no'              => $phoneNo,
        ]);
        $user->roles()->sync($roleId);

    }


    /**
     * Update Minister User
     *
     * @param int $userId
     * @param string $firstName
     * @param string $address
     * @param string $email
     * @param string $password
     * @param string $userType
     * @param int $roleId
     * @param int $status
     * @param int $ministryId
     * @param $officeId
     * @param string $phoneNo
     * @return void
     */
    public function updateMinisterUser(int $userId, string $firstName, string $address, string $email, string $password, string $userType, int $roleId, int $status, int $ministryId, $officeId ,string $phoneNo)
    {
        $user = User::findOrFail($userId);
        $user->update([
            'name'          => $firstName,
            'address'       => $address,
            'email'         => $email,
            'password'      => bcrypt($password),
            'type'          => $userType,
            'ministry_id'   => $ministryId,
            'lg_id'         => null,
            'office_id'     => isset($officeId) ? $officeId ?? '' : null,
            'status'        => $status,
            'phone_no'      => $phoneNo,
        ]);
        $user->roles()->sync($roleId);
        return $user;
    }


    /**
     * Create Local Government User
     *
     * @param string $firstName
     * @param string $address
     * @param string $email
     * @param string $password
     * @param string $userType
     * @param int $roleId
     * @param int $status
     * @param int $lgId
     * @param string $phoneNo
     * @return mixed
     */
    public function createLgUser(string $firstName, string $address, string $email, string $password, string $userType, int $roleId, int $status, int $lgId, string $phoneNo)
    {
        $user = User::create([
            'name'          => $firstName,
            'address'       => $address,
            'email'         => $email,
            'password'      => bcrypt($password),
            'type'          => $userType,
            'status'        => $status,
            'lg_id'         => $lgId,
            'ministry_id'   => null,
            'office_id'     => null,
            'phone_no'      => $phoneNo,
        ]);
        $user->roles()->sync($roleId);
        return $user;
    }


    /**
     * Update Local Government User
     *
     * @param int $userId
     * @param string $firstName
     * @param string $address
     * @param string $email
     * @param string $password
     * @param string $userType
     * @param int $roleId
     * @param int $status
     * @param int $lgId
     * @param string $phoneNo
     * @return void
     */
    public function updateLgUser(int $userId, string $firstName, string $address, string $email, string $password, string $userType, int $roleId,int $status , int $lgId, string $phoneNo)
    {
        $user = User::findOrFail($userId);
        $user->update([
            'name'          => $firstName,
            'address'       => $address,
            'email'         => $email,
            'password'      => bcrypt($password),
            'type'          => $userType,
            'status'        => $status,
            'lg_id'         => $lgId,
            'ministry_id'   => null,
            'office_id'     => null,
            'phone_no'      => $phoneNo,
        ]);
        $user->roles()->sync($roleId);
        return $user;
    }


    /**
     * Create Ministry Office User
     *
     * @param string $firstName
     * @param string $address
     * @param string $email
     * @param string $password
     * @param string $userType
     * @param int $roleId
     * @param int $status
     * @param int $officeId
     * @param string $phoneNo
     * @return mixed
     */
    public function createMinistryOfficeUser(string $firstName, string $address, string $email, string $password, string
    $userType, int $roleId, int $status, int $officeId, string $phoneNo)
    {
        $user = User::create([
            'name'          => $firstName,
            'address'       => $address,
            'email'         => $email,
            'password'      => bcrypt($password),
            'type'          => $userType,
            'status'        => $status,
            'lg_id'         => null,
            'ministry_id'   => null,
            'office_id'     => $officeId,
            'phone_no'      => $phoneNo,
        ]);
        $user->roles()->sync($roleId);
        return $user;
    }


    /**
     * Update Ministry Office User
     *
     * @param int $userId
     * @param string $firstName
     * @param string $address
     * @param string $email
     * @param string $password
     * @param string $userType
     * @param int $roleId
     * @param int $status
     * @param int $officeId
     * @param string $phoneNo
     * @return void
     */
    public function updateMinistryOfficeUser(int $userId, string $firstName, string $address, string $email, string $password, string
    $userType, int $roleId,int $status , int $officeId, string $phoneNo)
    {
        $user = User::findOrFail($userId);
        $user->update([
            'name'          => $firstName,
            'address'       => $address,
            'email'         => $email,
            'password'      => bcrypt($password),
            'type'          => $userType,
            'status'        => $status,
            'lg_id'         => null,
            'ministry_id'   => null,
            'office_id'     => $officeId,
            'phone_no'      => $phoneNo,
        ]);
        $user->roles()->sync($roleId);
        return $user;
    }


    /**
     * Get User By Slug
     *
     * @param string $slug
     * @return Role
     */
    public function getRoleBySlug(string $slug)
    {
        return Role::where('slug', $slug)->first();
    }


    /**
     * Get Ministry Users
     * @param string $name
     * @param string $email
     * @param string $status
     * @param string $paginationNo
     * @return mixed
     */
    public function getMinistryUsers(string $name, string $email, string $status, string $paginationNo)
    {
        $ministryUsers = User::select(
            'users.*', 'users.id as user_id', 'users.name as full_name')
            ->with('roles', 'ministry','ministry_office')
            ->join('ministries', 'users.ministry_id', 'ministries.id')
            ->where('users.ministry_id', $this->getAuthMinistryId())
            ->where('users.status', 1)
            ->where('ministries.status', 1)
            ->where(function ($query) use ($name, $email, $status) {
                if (!isStringEmpty($name)) {
                    $query->where('users.name', 'LIKE', '%'.$name.'%');
                }
                if (!isStringEmpty($email)) {
                    $query->where('users.email', 'LIKE', '%'.$email.'%');
                }
                if (!isStringEmpty($status)) {
                    $query->where('users.status', (bool) $status);
                }
            })
            ->paginate($this->getPaginationNo($paginationNo));

        if (!$ministryUsers){
            return $ministryUsers;
        }
        $ministryUserLists = [];
        foreach ($ministryUsers as $ministryUser)
        {
            if ($ministryUser->roles[0]->slug == getMinistryAdminRole()){

            }else
                $ministryUserLists[] = $ministryUser;
        }
        return $ministryUserLists;
    }


    /**
     * Get LG Users
     * @param string $name
     * @param string $email
     * @param string $status
     * @param string $paginationNo
     * @return mixed
     */
    public function getLgUsers(string $name, string $email, string $status, string $paginationNo)
    {
        $lgUsers = User::with('local_government','roles')
            ->where('users.lg_id', $this->getAuthLgId())
            ->where(function ($query) use ($name, $email, $status) {
                if (!isStringEmpty($name)) {
                    $query->where('users.name', 'LIKE', '%'.$name.'%');
                }
                if (!isStringEmpty($email)) {
                    $query->where('users.email', 'LIKE', '%'.$email.'%');
                }
                if (!isStringEmpty($status)) {
                    $query->where('users.status', (bool) $status);
                }
            })
            ->paginate($this->getPaginationNo($paginationNo));

        if (!$lgUsers){
            return $lgUsers;
        }
        $lgUsersLists = [];
        foreach ($lgUsers as $lgUser)
        {
            if ($lgUser->roles[0]->slug == getLgAdminRole()){

            }else
                $lgUsersLists[] = $lgUser;
        }
        return $lgUsersLists;
    }


    /**
     * Get Ministry Roles
     *
     * @return mixed
     */
    public function getMinistryRoles()
    {
        return Role::whereIn('slug', getMinistryRoles())->get();
    }


    /**
     * Get Lg Roles
     *
     * @return mixed
     */
    public function getLgRoles()
    {
        return Role::whereIn('slug', getLgRoles())->get();
    }

    /**
     * Get Ministry Office Roles
     *
     * @return mixed
     */
    public function getMinistryOfficeRoles()
    {
        return Role::whereIn('slug', getMinistryOfficeRoles())->get();
    }


    /**
     * Get Lg Officers
     *
     * @param string $provinceId
     * @param string $districtId
     * @param string $name
     * @param string $email
     * @param string $status
     * @param string $paginationNo
     * @return mixed
     */
    public function getLgOfficers(string $provinceId, string $districtId, string $name, string $email, string $status, string $paginationNo)
    {
        $lgOfficersUsers = User::select(
            'users.*', 'users.id as user_id')
            ->with('roles', 'local_government')
            ->join('local_governments', 'users.lg_id', 'local_governments.id')
            ->where('users.status', 1)
            ->where('local_governments.status', 1)
            ->where(function ($query) use ($provinceId, $districtId, $name, $email, $status) {
                if (!isStringEmpty($provinceId)) {
                    $query->where('local_governments.province_id', $provinceId);
                }
                if (!isStringEmpty($districtId)) {
                    $query->where('local_governments.district_id', $districtId);
                }
                if (!isStringEmpty($name)) {
                    $query->where('users.name', 'LIKE', '%'.$name.'%');
                }
                if (!isStringEmpty($email)) {
                    $query->where('users.email', 'LIKE', '%'.$email.'%');
                }
                if (!isStringEmpty($status)) {
                    $query->where('users.status', (bool) $status);
                }
            })
            ->paginate($this->getPaginationNo($paginationNo));

        if (!$lgOfficersUsers){
            return false;
        }
//        $lgOfficersUserLists = [];
        foreach ($lgOfficersUsers as $lgOfficerUser)
        {
            if ($lgOfficerUser->roles[0]->slug == getLgOfficerRole()){
                $lgOfficersUserLists[] = $lgOfficerUser;
            }
        }
        return $lgOfficersUserLists;
    }


    /**
     * Get Ministry Officers
     *
     * @param string $ministryId
     * @return mixed
     */
    public function getMinistryOfficers(string $ministryId)
    {
        return Ministry::select(
            'ministries.id as ministry_id','users.name','users.email', 'users.phone_no',
            'roles.id as role_id', 'roles.name as role_name', 'roles.slug as role_slug'
        )
            ->join('users', 'ministries.id', 'users.ministry_id')
            ->join('user_roles', 'user_roles.user_id', 'user_roles.role_id')
            ->join('roles', 'user_roles.role_id', 'roles.id')
            ->where(function ($query) use ($ministryId) {
                if (!isStringEmpty($ministryId)) {
                    $query->where('ministries.id', $ministryId);
                }
            })
            ->where('roles.slug', getMinistryOfficerRole())
            ->first();
    }

    /**
     * Get Ministry Office Users
     * @param string $name
     * @param string $email
     * @param string $status
     * @param string $paginationNo
     * @return mixed
     */
    public function getMinistryOfficeUsers(string $name, string $email, string $status, string $paginationNo)
    {
        $ministryOfficeUsers =  User::with('ministry_office','roles')
            ->where('users.office_id', $this->getAuthMinistryOfficeId())
            ->where(function ($query) use ($name, $email, $status) {
                if (!isStringEmpty($name)) {
                    $query->where('users.name', 'LIKE', '%'.$name.'%');
                }
                if (!isStringEmpty($email)) {
                    $query->where('users.email', 'LIKE', '%'.$email.'%');
                }
                if (!isStringEmpty($status)) {
                    $query->where('users.status', (bool) $status);
                }
            })
            ->paginate($this->getPaginationNo($paginationNo));

        if (!$ministryOfficeUsers){
            return $ministryOfficeUsers;
        }
        $ministryOfficeUserLists = [];
        foreach ($ministryOfficeUsers as $ministryOfficeUser)
        {
            if($ministryOfficeUser->roles[0]->slug == getMinistryOfficeAdminRole()){

            }else
                $ministryOfficeUserLists[] = $ministryOfficeUser;
        }
        return $ministryOfficeUserLists;
    }


    /**
     * Create Ministry Office User
     *
     * @param string $name
     * @param string $nameEn
     * @param string $email
     * @param string $phoneNo
     * @param string $address
     * @param string $status
     * @return mixed
     */
    public function createMinistryOffice(string $name,string $nameEn , string $email, string $phoneNo,  string $address, string $status)
    {
        return MinistryOffices::create([
            'name'          => $name,
            'address'       => $address,
            'email'         => $email,
            'name_en'       => $nameEn,
            'phone_no'      => $phoneNo,
            'ministry_id'   => $this->getAuthMinistryId(),
            'status'        => ($status != "") ? $status : 1,
        ]);
    }

    /**
     * Update Ministry Office User
     *
     * @param int $moId
     * @param string $name
     * @param string $nameEn
     * @param string $email
     * @param string $address
     * @param string $phoneNo
     * @param string $status
     * @return void
     */
    public function updateMinistryOffice(int $moId, string $name, string $nameEn, string $email
            , string $address,string $phoneNo, string $status)
    {
        $ministryOfficeUser = MinistryOffices::findOrFail($moId);
        $ministryOfficeUser->update([
            'name'          => $name,
            'name_en'       => $nameEn,
            'email'         => $email,
            'address'       => $address,
            'phone_no'      => $phoneNo,
            'status'        => ($status != "") ? $status : 1,
        ]);
        return $ministryOfficeUser;
    }

    /**
     * list Ministry Office Users
     *
     * @return mixed
     */
    public function listMinistryOffices()
    {
        return MinistryOffices::where('ministry_id', $this->getAuthMinistryId())->get();
    }
}
