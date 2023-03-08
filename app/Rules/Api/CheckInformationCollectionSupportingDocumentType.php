<?php

namespace App\Rules\Api;

use Illuminate\Contracts\Validation\Rule;

class CheckInformationCollectionSupportingDocumentType implements Rule
{
    private $documentType;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($documentType)
    {
        $this->documentType = $documentType;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $supportingDoc
     * @return bool
     */
    public function passes($attribute, $supportingDoc)
    {
        $fileExtension = $supportingDoc->getClientOriginalExtension();
        if(in_array($fileExtension, $this->documentType)){
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Document type not matched';
    }
}
