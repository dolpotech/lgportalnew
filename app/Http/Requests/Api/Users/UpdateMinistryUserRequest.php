<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\ApiRequest;
use App\Rules\Api\CheckCreatingMinistryOfficeUserStatus;
use App\Rules\Api\CheckCreatingMinistryUserStatus;
use App\Rules\Api\CheckUserTypeMinistryOrMinistryOffice;
use App\Rules\Api\IsRoleBelongsToMinistryRoles;
use Illuminate\Validation\Rule;

class UpdateMinistryUserRequest extends ApiRequest
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
            'user_id'       => ['required', 'exists:users,id'],
            'first_name'    => 'required',
            'address'       => 'nullable',
            'email'         => ['required', 'email', Rule::unique('users')->ignore($this->get('user_id'))],
            'new_password'  => 'nullable|min:8',
            'role_id'       => ['required', new IsRoleBelongsToMinistryRoles($this->get('office_id'))],
            'user_type'     => ['required', new CheckUserTypeMinistryOrMinistryOffice($this->get('office_id'))],
            'phone_no'      => 'nullable',
            'ministry_id'   => ['required', 'exists:ministries,id', new CheckCreatingMinistryUserStatus()],
            'office_id'     => ['nullable', new CheckCreatingMinistryOfficeUserStatus()]
        ];
    }
}
