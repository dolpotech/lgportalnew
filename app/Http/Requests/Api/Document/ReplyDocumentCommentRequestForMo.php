<?php

namespace App\Http\Requests\Api\Document;

use App\Http\Requests\ApiRequest;
use App\Rules\Api\IsDocumentCommentBelongsToUserMo;
use App\Rules\Api\IsUserMoOfficer;

class ReplyDocumentCommentRequestForMo extends ApiRequest
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
            'comment_id'    => ['required', 'exists:document_comments,id', new IsDocumentCommentBelongsToUserMo(), new IsUserMoOfficer()],
            'message'       => ['required'],
        ];
    }
}
