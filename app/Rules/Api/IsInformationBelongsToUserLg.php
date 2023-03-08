<?php

namespace App\Rules\Api;

use App\HelperClasses\Traits\AuthHelper;
use App\Models\InformationReceiver;
use Illuminate\Contracts\Validation\Rule;

class IsInformationBelongsToUserLg implements Rule
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
        return $information->lg_id == $this->getAuthLgId();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This information does not belongs to your local government';
    }
}
