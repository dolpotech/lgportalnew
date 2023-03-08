<?php

namespace App\Http\Requests;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Contracts\Validation\Validator;

class ApiRequest extends FormRequest
{
    /**
     *
     * @param Validator $validator
     * @return Application|ResponseFactory|Response
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
