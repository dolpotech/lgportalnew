<?php

namespace App\Rules\Api;

use App\HelperClasses\Traits\AuthHelper;
use App\Models\LocalGovernment;
use Illuminate\Contracts\Validation\Rule;

class CheckCreatingLgUserStatus implements Rule
{
    use AuthHelper;

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $lgId
     * @return bool
     */
    public function passes($attribute, $lgId)
    {
        if (!$lgId){
            return true;
        }
        $lg = LocalGovernment::where('id', $lgId)->first();
        if ($lg->status == 0)
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
        return 'This lg user is inactive';
    }
}
