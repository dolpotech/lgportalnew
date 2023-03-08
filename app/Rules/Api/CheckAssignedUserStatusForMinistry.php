<?php

namespace App\Rules\Api;

use App\HelperClasses\Traits\AuthHelper;
use App\Models\Ministry;
use Illuminate\Contracts\Validation\Rule;

class CheckAssignedUserStatusForMinistry implements Rule
{
    use AuthHelper;


    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $ministryIds
     * @return bool
     */
    public function passes($attribute, $ministryIds)
    {
        if (!$ministryIds){
            return true;
        }
        foreach ($ministryIds as $ministryId){
            $ministry = Ministry::where('id', $ministryId)->first();
            if ($ministry->status == 0)
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
        return 'One of the Ministry user is inactive so you cannot assign to that Ministry user';
    }
}
