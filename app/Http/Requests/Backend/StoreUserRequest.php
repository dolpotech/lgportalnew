<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'first_name'    => 'required',
            'address'       => 'nullable',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|min:8',
            'role'          => 'required',
            'type'          => 'required',
            'phone'         => 'nullable',
        ];
    }
}
