<?php

namespace App\Http\Requests\Api\Document;

use App\Http\Requests\ApiRequest;
use App\Rules\Api\IsDocumentBelongsToUserLg;
use App\Rules\Api\IsDocumentCommentBelongsToUserLg;
use App\Rules\Api\IsUserLgCao;
use App\Rules\Api\IsUserLgOfficer;

class ReplyDocumentCommentRequestForLg extends ApiRequest
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
            'comment_id'    => ['required', 'exists:document_comments,id', new IsDocumentCommentBelongsToUserLg(), new IsUserLgOfficer()],
            'message'       => ['required'],
        ];
    }
}
