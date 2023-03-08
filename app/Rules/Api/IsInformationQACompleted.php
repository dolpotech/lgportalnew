<?php

namespace App\Rules\Api;

use App\HelperClasses\Traits\AuthHelper;
use App\Models\InformationReceiver;
use App\Models\TemplateField;
use Illuminate\Contracts\Validation\Rule;

class IsInformationQACompleted implements Rule
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
            ->withCount('documents')
            ->first();

        $countTemplateFields = TemplateField::where('template_id', $information->template_id)->count();

        return $countTemplateFields == $information->documents_count;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'All information is not collected yet';
    }
}
