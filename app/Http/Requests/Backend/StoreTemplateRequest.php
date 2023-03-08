<?php

namespace App\Http\Requests\Backend;


use App\Http\Requests\ApiRequest;
use App\Rules\VerifyTemplateFields;
use Illuminate\Validation\Rule;

class StoreTemplateRequest extends ApiRequest
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
            "template_name"              => "required|unique:templates,name",
            // "insertion_type"    => ["required", Rule::in(getTemplateInsertionType())],
            'fields'            => ['array', new VerifyTemplateFields()]
        ];
    }
} {
}
