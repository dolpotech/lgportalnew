<?php

namespace App\Rules\Api;

use App\Models\LocalGovernment;
use App\Models\Ministry;
use App\Models\Role;
use Illuminate\Contracts\Validation\Rule;

class IsRoleBelongsToMinistryRoles implements Rule
{

    private $officeId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($officeId)
    {
        $this->officeId = $officeId;
    }

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
        if ($this->officeId)
        {
            if (in_array($role->slug, getMinistryOfficeRoles())){
                return true;
            }
            else
                return false;
        }
        if (!$role) {
            return false;
        }

        if ($role->slug == getMinistryAdminRole())
        {
            return false;
        }

        if (!in_array($role->slug, getMinistryRoles())) {
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
        return 'Role is not associated with any roles';
    }
}
