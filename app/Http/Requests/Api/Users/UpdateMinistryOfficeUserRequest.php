<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\ApiRequest;
use App\Rules\Api\CheckCreatingMinistryOfficeUserStatus;
use App\Rules\Api\IsRoleBelongsToMinistryOfficeRoles;
use Illuminate\Validation\Rule;

class UpdateMinistryOfficeUserRequest extends ApiRequest
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
            'role_id'       => ['required', new IsRoleBelongsToMinistryOfficeRoles()],
            'user_type'     => 'required|in:ministry_office',
            'phone_no'      => 'nullable',
            'office_id'     => ['required','exists:ministry_offices,id', new CheckCreatingMinistryOfficeUserStatus()]
        ];
    }
}
