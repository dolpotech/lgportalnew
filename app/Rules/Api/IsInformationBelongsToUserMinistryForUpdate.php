<?php

namespace App\Rules\Api;

use App\HelperClasses\Traits\AuthHelper;
use App\Models\InformationDocument;
use App\Models\InformationReceiver;
use Illuminate\Contracts\Validation\Rule;

class IsInformationBelongsToUserMinistryForUpdate implements Rule
{
    use AuthHelper;


    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $documentId
     * @return bool
     */
    public function passes($attribute, $documentId)
    {
        $document = InformationDocument::where('id', $documentId)->first();

        if (!$document) {
            return false;
        }
        $information = InformationReceiver::where('id', $document->info_receiver_id)->first();
        if (!$information) {
            return false;
        }
        return $information->ministry_id == $this->getAuthMinistryId();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This information does not belongs to your Ministry';
    }
}
