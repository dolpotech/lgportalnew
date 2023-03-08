<?php

namespace App\Rules\Api;

use App\HelperClasses\Traits\AuthHelper;
use App\Models\InformationCollection;
use App\Models\InformationDocument;
use Illuminate\Contracts\Validation\Rule;

class IsDocumentBelongsToUserLg implements Rule
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
        $information = InformationDocument::join('info_receivers', 'documents.info_receiver_id', 'info_receivers.id')
            ->join('information_collection', 'info_receivers.information_id', 'information_collection.id')
            ->where('documents.id', $documentId)
            ->first();

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
        return 'This document does not belongs to your local government';
    }
}
