<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\ApiRequest;
use App\Rules\Api\CheckCreatingMinistryOfficeUserStatus;
use App\Rules\Api\IsRoleBelongsToMinistryOfficeRoles;

class StoreMinistryOfficeUserRequest extends ApiRequest
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
            'first_name'    => 'required',
            'address'       => 'nullable',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|confirmed|min:8',
            'role_id'       => ['required', new IsRoleBelongsToMinistryOfficeRoles()],
            'user_type'     => 'required|in:ministry_office',
            'phone_no'      => 'nullable',
            'office_id'     => ['required','exists:ministry_offices,id', new CheckCreatingMinistryOfficeUserStatus()]
        ];
    }
}
