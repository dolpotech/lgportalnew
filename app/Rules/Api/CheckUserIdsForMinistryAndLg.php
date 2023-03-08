<?php

namespace App\Rules\Api;

use App\Models\LocalGovernment;
use App\Models\Ministry;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class CheckUserIdsForMinistryAndLg implements Rule
{
    protected $userType;
    protected $errorMessage;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($userType)
    {
        $this->userType = $userType;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $userIds
     * @return bool
     */
    public function passes($attribute, $userIds)
    {
        if (!in_array($this->userType, ['ministry', 'local_government'])) {
            $this->errorMessage = 'User type does not match';
            return false;
        }

        $countUser = User::whereIn('users.id', $userIds)
            ->join('roles', 'users.role_id', 'roles.id')
            ->where('roles.slug', getLgOfficerRole())
            ->where('users.type', $this->userType)
            ->count();

        if ($this->userType == 'ministry') {
            $this->errorMessage = 'Ministry Officers does not exists';
            return $countUser == count($userIds);
        }


        $this->errorMessage = 'Local Government Officers does not exists';
        return $countUser == count($userIds);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->errorMessage;
    }
}
