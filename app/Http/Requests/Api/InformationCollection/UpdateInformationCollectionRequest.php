<?php

namespace App\Http\Requests\Api\InformationCollection;

use App\Http\Requests\ApiRequest;
use App\Rules\Api\CheckInformationCollectionDocumentType;
use App\Rules\Api\CheckInformationCollectionSupportingDocumentType;
use App\Rules\Api\CheckStartDate;
use App\Rules\Api\CheckSubmissionDate;
use App\Rules\Api\ExistInLgs;
use App\Rules\Api\ExistInMinistries;
use App\Rules\Api\ExistInMinistryOffices;
use Illuminate\Validation\Rule;

class UpdateInformationCollectionRequest extends ApiRequest
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
//, new CheckInformationCollectionDocumentType($this->get('document_type'))
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'information_id'    => ['required', 'exists:information_collection,id'],
            'title'             => ['required'],
            'type'              => ['required', Rule::in(getInfoCollectionType())],
            'template_id'       => ['nullable'],
            'main_doc'          => ['nullable', new CheckInformationCollectionDocumentType($this->get('document_type'))],
            'supporting_doc'    => ['nullable', new CheckInformationCollectionSupportingDocumentType($this->get('document_type'))],
            'document_type'     => ['nullable'],
            'description'       => ['nullable'],
            'assigner_id'       => ['nullable'],
            'priority'          => ['required', Rule::in(getPriorityLevel())],
            'start_date'         => [new CheckStartDate($this->get('type'))],
            'submission_date'    => [new CheckSubmissionDate($this->get('type'), $this->get('start_date'))],
            'ministry_ids'      => ['nullable', 'array', new ExistInMinistries()],
            'lg_ids'            => ['nullable', 'array', new ExistInLgs()],
            'office_ids'        => ['nullable', 'array', new ExistInMinistryOffices()],
        ];
    }


}
