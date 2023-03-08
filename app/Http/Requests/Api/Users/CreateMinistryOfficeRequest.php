<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\ApiRequest;

class CreateMinistryOfficeRequest extends ApiRequest
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
            'name'              => ['required'],
            'name_en'           => ['nullable'],
            'email'             => 'required|email|unique:ministry_offices',
            'address'           => ['nullable'],
            'phone_no'          => ['nullable'],
        ];
    }


}
