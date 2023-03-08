<?php

namespace App\Http\Requests\Api\InformationCollection;

use App\Http\Requests\ApiRequest;
use App\Rules\Api\IsInformationBelongsToUser;
use App\Rules\Api\IsInformationCompleted;
use App\Rules\Api\IsInformationQACompleted;

class SetInformationCompletedRequest extends ApiRequest
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
            'info_receiver_id'    => ['required', 'exists:info_receivers,id',
                //new IsInformationBelongsToUser(),
                new IsInformationCompleted(),
            ],
        ];
    }

}
