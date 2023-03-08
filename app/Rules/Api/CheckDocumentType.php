<?php

namespace App\Rules\Api;

use App\Models\InformationCollection;
use App\Models\InformationReceiver;
use Illuminate\Contracts\Validation\Rule;

class CheckDocumentType implements Rule
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
     * @param $mainDoc
     * @return bool
     */
    public function passes($attribute, $document)
    {
        $information = InformationReceiver::join('information_collection', 'info_receivers.information_id', 'information_collection.id')
            ->where('info_receivers.id', $this->infoReceiverId)
            ->first();

        if (!$information){
            return false;
        }

        $documentTypes = convertToArray($information->document_type);

        if(in_array($document->getClientOriginalExtension(), $documentTypes)){
            return true;
        }

        return false;
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
