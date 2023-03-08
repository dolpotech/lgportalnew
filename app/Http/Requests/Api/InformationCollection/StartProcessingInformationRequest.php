<?php

namespace App\Http\Requests\Api\InformationCollection;

use App\Http\Requests\ApiRequest;
use App\Rules\Api\CheckIfLgsOrMinistries;
use App\Rules\Api\CheckTargetIdForMinistryAndLg;
use App\Rules\Api\CheckUserIdsForMinistryAndLg;
use App\Rules\Api\IsInformationBelongsToUserLg;
use Illuminate\Validation\Rule;

class StartProcessingInformationRequest extends ApiRequest
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
            'information_id'    => ['required', 'exists:information_collection,id', new IsInformationBelongsToUserLg()],
        ];
    }

}
