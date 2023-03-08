<?php

namespace App\Rules\Api;

use App\HelperClasses\Traits\AuthHelper;
use App\Models\InformationReceiver;
use App\Models\LocalGovernment;
use Illuminate\Contracts\Validation\Rule;

class CheckAssignedUserStatusForLg implements Rule
{
    use AuthHelper;


    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $lgIds
     * @return bool
     */
    public function passes($attribute, $lgIds)
    {
        if (!$lgIds){
            return true;
        }
        foreach ($lgIds as $lgId){
            $lg = LocalGovernment::where('id', $lgId)->first();
            if ($lg->status == 0)
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
        return 'One of the Lg user is inactive so you cannot assign to that lg user';
    }
}
