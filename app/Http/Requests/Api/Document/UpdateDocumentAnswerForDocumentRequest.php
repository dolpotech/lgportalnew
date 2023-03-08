<?php

namespace App\Http\Requests\Api\Document;

use App\HelperClasses\Traits\AuthHelper;
use App\Http\Requests\ApiRequest;


class UpdateDocumentAnswerForDocumentRequest extends ApiRequest
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
            'document_id'       => ['required', 'exists:documents,id'],
            'answer'            => 'required',
        ];
    }
}
