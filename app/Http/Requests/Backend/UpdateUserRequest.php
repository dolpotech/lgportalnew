<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'id'            => ['required', 'exists:users,id'],
            'first_name'    => 'required',
            'address'       => 'nullable',
            'email'         => ['required', 'email', Rule::unique('users')->ignore($this->get('id'))],
            'role'          => 'required',
            'type'          => 'required',
            'phone'         => 'nullable',
        ];
    }
}
