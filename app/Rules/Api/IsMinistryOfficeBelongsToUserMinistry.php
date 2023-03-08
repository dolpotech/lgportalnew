<?php

namespace App\Rules\Api;

use App\HelperClasses\Traits\AuthHelper;
use App\Models\InformationReceiver;
use App\Models\MinistryOffices;
use Illuminate\Contracts\Validation\Rule;

class IsMinistryOfficeBelongsToUserMinistry implements Rule
{
    use AuthHelper;


    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $moId
     * @return bool
     */
    public function passes($attribute, $moId)
    {
        $ministryOffice = MinistryOffices::where('id', $moId)->first();

        if (!$ministryOffice) {
            return false;
        }
        return $ministryOffice->ministry_id == $this->getAuthMinistryId();
    }


    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This information does not belongs to your ministry';
    }
}
