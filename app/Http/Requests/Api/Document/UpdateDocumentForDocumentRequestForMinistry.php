<?php

namespace App\Http\Requests\Api\Document;

use App\HelperClasses\Traits\AuthHelper;
use App\Http\Requests\ApiRequest;
use App\Rules\Api\IsInformationBelongsToUserMinistry;
use App\Rules\Api\IsInformationInvitationOnReceiver;

class UpdateDocumentForDocumentRequestForMinistry extends ApiRequest
{
    use AuthHelper;


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'info_receiver_id'  => ['required','exists:info_receivers,id', new IsInformationBelongsToUserMinistry(), new IsInformationInvitationOnReceiver()],
            'main_doc'          => 'required',
            'supporting_doc'    => 'nullable',
        ];
    }
}
