<?php

namespace App\Rules\Api;

use Illuminate\Contracts\Validation\Rule;

class CheckUserTypeMinistryOrMinistryOffice implements Rule
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
     * @param $userType
     * @return bool
     */
    public function passes($attribute, $userType)
    {
        if ($this->officeId)
        {
            if ($userType == 'ministry_office'){
                return true;
            }
            else
                return false;
        }else{
            if ($userType == 'ministry'){
                return true;
            }
            else
                return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'User type must match with creating user';
    }
}
