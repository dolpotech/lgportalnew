<?php

namespace App\Http\Requests\Api\Document;

use App\HelperClasses\Traits\AuthHelper;
use App\Http\Requests\ApiRequest;
use App\Rules\Api\CheckDocumentType;
use App\Rules\Api\EscapeOrCheckDocumentType;
use App\Rules\Api\HaveAlreadyDocuments;
use App\Rules\Api\IsInformationBelongsToUserLg;
use App\Rules\Api\IsInformationInvitationOnReceiver;

class CreateDocumentRequestForLG extends ApiRequest
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
            'info_receiver_id'          => [
                'required',
                'exists:info_receivers,id',
                new IsInformationBelongsToUserLg(),
                new IsInformationInvitationOnReceiver(),
                new HaveAlreadyDocuments()
            ],
            'main_doc'                  => ['required', 'file', new CheckDocumentType($this->get('info_receiver_id'))],
            'supporting_doc'            => ['nullable', 'file', new EscapeOrCheckDocumentType($this->get('info_receiver_id'))],
        ];
    }
}
