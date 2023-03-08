<?php

namespace App\Rules\Api;

use App\HelperClasses\Traits\AuthHelper;
use App\Models\Ministry;
use Illuminate\Contracts\Validation\Rule;

class CheckCreatingMinistryUserStatus implements Rule
{
    use AuthHelper;


    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $ministryId
     * @return bool
     */
    public function passes($attribute, $ministryId)
    {
        if (!$ministryId){
            return true;
        }
        $ministry = Ministry::where('id', $ministryId)->first();
        if ($ministry->status == 0)
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
        return 'This Ministry user is inactive';
    }
}
