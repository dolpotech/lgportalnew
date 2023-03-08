<?php

namespace App\Rules\Api;

use App\HelperClasses\Traits\AuthHelper;
use App\Models\MinistryOffices;
use Illuminate\Contracts\Validation\Rule;

class CheckCreatingMinistryOfficeUserStatus implements Rule
{
    use AuthHelper;


    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $officeId
     * @return bool
     */
    public function passes($attribute, $officeId)
    {
        if (!$officeId){
            return true;
        }
        $Mo = MinistryOffices::where('id', $officeId)->first();
        if ($Mo->status == 0)
        {
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
        return 'This Ministry office User is inactive';
    }
}
