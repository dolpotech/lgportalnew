<?php

namespace App\Rules\Api;

use App\HelperClasses\Traits\AuthHelper;
use App\Models\InformationReceiver;
use Illuminate\Contracts\Validation\Rule;

class IsInformationBelongsToUserMO implements Rule
{
    use AuthHelper;


    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $infoReceiverId
     * @return bool
     */
    public function passes($attribute, $infoReceiverId)
    {
        $information = InformationReceiver::where('id', $infoReceiverId)->first();

        if (!$information) {
            return false;
        }
        return $information->office_id == $this->getAuthMinistryOfficeId();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This information does not belongs to your Ministry Office';
    }
}
