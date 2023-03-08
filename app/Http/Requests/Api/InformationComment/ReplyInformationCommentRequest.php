<?php

namespace App\Http\Requests\Api\InformationComment;

use App\Http\Requests\ApiRequest;
use App\Rules\Api\IsCommentRelatedToMinistry;

class ReplyInformationCommentRequest extends ApiRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'comment_id'        => ['required', 'exists:information_comments,id', new IsCommentRelatedToMinistry()],
            'message'           => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'information_id.exists' => 'Information does not exists',
            'message.required' => 'Reply is required',
        ];
    }

}
