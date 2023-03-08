<?php

namespace App\Http\Requests\Api\Users;

use App\Http\Requests\ApiRequest;
use App\Rules\Api\CheckCreatingLgUserStatus;
use App\Rules\Api\IsRoleBelongsToLgRoles;
use Illuminate\Validation\Rule;

class StoreLgUserRequest extends ApiRequest
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
            'role_id'       => ['required', new IsRoleBelongsToLgRoles()],
            'user_type'     => 'required|in:local_government',
            'phone_no'      => 'nullable',
            'lg_id'         => ['required','exists:local_governments,id', new CheckCreatingLgUserStatus()]
        ];
    }
}
