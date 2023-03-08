<?php

namespace App\Rules\Api;

use App\Models\Document;
use App\Models\InformationDocument;
use Illuminate\Contracts\Validation\Rule;

class IsDocumentFieldAlreadyExist implements Rule
{
    private $infoReceiverId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($infoReceiverId)
    {
        $this->infoReceiverId = $infoReceiverId;
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
        $documentCount = InformationDocument::where('info_receiver_id', $this->infoReceiverId)
            ->where('field_id', $fieldId)
            ->count();
        return !($documentCount > 0);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Document has been already created';
    }
}
