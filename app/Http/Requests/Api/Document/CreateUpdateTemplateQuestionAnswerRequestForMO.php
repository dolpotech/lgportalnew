<?php

namespace App\Http\Requests\Api\Document;

use App\HelperClasses\Traits\AuthHelper;
use App\Http\Requests\ApiRequest;
use App\Rules\Api\IsInformationBelongsToUserMO;

class CreateUpdateTemplateQuestionAnswerRequestForMO extends ApiRequest
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
            'info_receiver_id'      => ['required','exists:info_receivers,id', new IsInformationBelongsToUserMO()],
            'field_id'              => ['required','exists:template_fields,id'],
            'answer'                => 'required',
        ];
    }
}
