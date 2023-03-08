<?php

namespace App\Rules\Api;

use App\Models\InformationDocument;
use Illuminate\Contracts\Validation\Rule;

class DocumentFieldShouldExist implements Rule
{
    private $informationId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($informationId)
    {
        $this->informationId = $informationId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $fieldId
     * @return bool
     */
    public function passes($attribute, $fieldId)
    {
        $documentCount = InformationDocument::where('information_id', $this->informationId)
            ->where('field_id', $fieldId)
            ->count();

        return ($documentCount > 0);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Document does not exist';
    }
}
