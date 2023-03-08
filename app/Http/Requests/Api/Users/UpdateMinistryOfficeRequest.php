<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\ApiRequest;
use App\Rules\Api\IsMinistryOfficeBelongsToUserMinistry;
use Illuminate\Validation\Rule;

class UpdateMinistryOfficeRequest extends ApiRequest
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
            'mo_id'             => ['required', 'exists:ministry_offices,id', new IsMinistryOfficeBelongsToUserMinistry()],
            'name'              => ['required'],
            'name_en'           => ['nullable'],
            'email'             => ['required', 'email', Rule::unique('ministry_offices')->ignore($this->get('mo_id'))],
            'address'           => ['nullable'],
            'phone_no'          => ['nullable'],
        ];
    }


}
