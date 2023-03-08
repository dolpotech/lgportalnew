<?php

namespace App\Rules\Api;

use App\HelperClasses\Traits\AuthHelper;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class DoesInformationBelongsToAuth implements Rule
{
    use AuthHelper;


    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $informationId
     * @return bool
     */
    public function passes($attribute, $informationId)
    {
        $userMinistryId = $this->getAuthMinistryId();
        $userLgId = $this->getAuthLgId();
        $userMinistryOfficeId = $this->getAuthMinistryOfficeId();

        $exist = DB::table('info_receivers')
            ->where('information_id', $informationId)
            ->orWhere('ministry_id', $userMinistryId)
            ->orWhere('lg_id', $userLgId)
            ->orWhere('office_id', $userMinistryOfficeId)
            ->exists();
        return $exist;

/*        if ($userType == 'ministry') {
            $userMinistryId = $this->getAuthMinistryId();

            return $query->where('ministry_id', $userMinistryId)->exists();
        }
        if ($userType == 'local_government') {
            $userLgId = $this->getAuthLgId();

            return $query->where('ministry_id', $userMinistryId)->exists();
        }
        if ($userType == 'ministry_office') {
            $userMinistryOfficeId = $this->getAuthMinistryOfficeId();
        }*/
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This information does not belongs to current user';
    }
}
