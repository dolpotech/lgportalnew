<?php

namespace App\Http\Requests\Api\Document;

use App\Http\Requests\ApiRequest;
use App\Rules\Api\IsDocumentBelongsToUserMo;
use App\Rules\Api\IsUserMoCao;

class CreateDocumentCommentRequestForMo extends ApiRequest
{
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
            'document_id' => ['required', new IsDocumentBelongsToUserMo(), new IsUserMoCao()],
        ];
    }
}
