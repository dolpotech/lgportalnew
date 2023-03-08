<?php

namespace App\Rules\Api;

use App\HelperClasses\Traits\AuthHelper;
use App\Models\InformationReceiver;
use Illuminate\Contracts\Validation\Rule;

class IsInformationInvitationOnReceiver implements Rule
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
        $information = InformationReceiver::join('information_collection', 'info_receivers.information_id', 'information_collection.id')
            ->where('info_receivers.id', $infoReceiverId)
            ->first();

        if (!$information) {
            return false;
        }

        return isInformationInvitational($information->type);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This information is not invitational';
    }
}
