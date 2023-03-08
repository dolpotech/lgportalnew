<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\ApiRequest;
use App\Rules\Api\CheckCreatingMinistryOfficeUserStatus;
use App\Rules\Api\CheckCreatingMinistryUserStatus;
use App\Rules\Api\CheckUserTypeMinistryOrMinistryOffice;
use App\Rules\Api\IsRoleBelongsToMinistryRoles;


class StoreMinistryUserRequest extends ApiRequest
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
            'role_id'       => ['required', new IsRoleBelongsToMinistryRoles($this->get('office_id'))],
            'user_type'     => ['required', new CheckUserTypeMinistryOrMinistryOffice($this->get('office_id'))],
            'phone_no'      => 'nullable',
            'ministry_id'   => ['required', 'exists:ministries,id', new CheckCreatingMinistryUserStatus()],
            'office_id'     => ['nullable', new CheckCreatingMinistryOfficeUserStatus()]
        ];
    }
}
