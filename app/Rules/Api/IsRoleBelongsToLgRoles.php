<?php

namespace App\Rules\Api;

use App\Models\LocalGovernment;
use App\Models\Ministry;
use App\Models\Role;
use Illuminate\Contracts\Validation\Rule;

class IsRoleBelongsToLgRoles implements Rule
{


    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $roleId
     * @return bool
     */
    public function passes($attribute, $roleId)
    {
        $role = Role::find($roleId);

        if (!$role) {
            return false;
        }

        if ($role->slug == getLgAdminRole())
        {
            return false;
        }

        if (!in_array($role->slug, getLgRoles())) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Role is not associated with any local government roles';
    }
}
