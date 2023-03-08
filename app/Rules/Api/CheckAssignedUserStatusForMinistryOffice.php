<?php

namespace App\Rules\Api;

use App\HelperClasses\Traits\AuthHelper;
use App\Models\MinistryOffices;
use Illuminate\Contracts\Validation\Rule;

class CheckAssignedUserStatusForMinistryOffice implements Rule
{
    use AuthHelper;


    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $ministryOfficeIds
     * @return bool
     */
    public function passes($attribute, $ministryOfficeIds)
    {
        if (!$ministryOfficeIds){
            return true;
        }
        foreach ($ministryOfficeIds as $ministryOfficeId){
            $Mo = MinistryOffices::where('id', $ministryOfficeId)->first();
            if ($Mo->status == 0)
            {
                return false;
            }
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
        return 'One of the Ministry Office user is inactive so you cannot assign to that Ministry Office user';
    }
}
