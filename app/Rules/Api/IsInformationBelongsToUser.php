<?php

namespace App\Rules\Api;

use App\HelperClasses\Traits\AuthHelper;
use App\Models\InformationReceiver;
use Illuminate\Contracts\Validation\Rule;

class IsInformationBelongsToUser implements Rule
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
        if ($information->lg_id != ''){
            return $information->lg_id == $this->getAuthLgId();
        }
        if ($information->ministry_id != ''){
            return $information->ministry_id == $this->getAuthMinistryId();
        }
        if ($information->office_id != ''){
            return $information->office_id == $this->getAuthMinistryOfficeId();
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This information does not belongs to your Information Collection';
    }
}
