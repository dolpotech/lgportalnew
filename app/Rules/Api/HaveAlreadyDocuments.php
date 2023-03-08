<?php

namespace App\Rules\Api;

use App\Models\InformationCollection;
use App\Models\InformationDocument;
use App\Models\InformationReceiver;
use Illuminate\Contracts\Validation\Rule;

class HaveAlreadyDocuments implements Rule
{


    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $infoReceiverId
     * @return bool
     */
    public function passes($attribute, $infoReceiverId)
    {
        $countDocuments = (int) InformationDocument::where('info_receiver_id', $infoReceiverId)->count();

        return $countDocuments === 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Information already have documents';
    }
}
