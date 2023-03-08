<?php

namespace App\Http\Requests\Api\InformationComment;

use App\Http\Requests\ApiRequest;
use App\Rules\Api\CheckTargetIdForMinistryAndLg;
use App\Rules\Api\CheckUserIdsForMinistryAndLg;
use App\Rules\Api\DoesInformationBelongsToAuth;
use App\Rules\Api\IsInformationBelongsToUserLg;
use Illuminate\Validation\Rule;

class CreateInformationCommentRequest extends ApiRequest
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
            'information_id'    => ['required', 'exists:information_collection,id', new DoesInformationBelongsToAuth()],
            'comment'           => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'information_id.exists' => 'Information does not exists',
            'comment.required' => 'Comment is required',
        ];
    }

}
