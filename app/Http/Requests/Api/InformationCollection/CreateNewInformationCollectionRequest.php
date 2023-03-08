<?php

namespace App\Http\Requests\Api\InformationCollection;

use App\Http\Requests\ApiRequest;
use App\Rules\Api\CheckAssignedUserStatusForLg;
use App\Rules\Api\CheckAssignedUserStatusForMinistry;
use App\Rules\Api\CheckAssignedUserStatusForMinistryOffice;
use App\Rules\Api\CheckInformationCollectionDocumentType;
use App\Rules\Api\CheckInformationCollectionSupportingDocumentType;
use App\Rules\Api\CheckSelectAllCondition;
use App\Rules\Api\CheckStartDate;
use App\Rules\Api\CheckSubmissionDate;
use App\Rules\Api\SelectAllInformationRules;
use Illuminate\Validation\Rule;

class CreateNewInformationCollectionRequest extends ApiRequest
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
            'title'              => ['required'],
            'type'               => ['required', Rule::in(getInfoCollectionType())],
            'template_id'        => ['nullable'],
            'document_type'      => ['required'],
            'main_doc'           => ['required', new CheckInformationCollectionDocumentType($this->get('document_type'))],
            'supporting_doc'     => ['nullable', new CheckInformationCollectionSupportingDocumentType($this->get('document_type'))],
            'description'        => ['nullable'],
            'assigner_id'        => ['nullable'],
            'priority'           => ['required', Rule::in(getPriorityLevel())],
            'start_date'         => [new CheckStartDate($this->get('type'))],
            'submission_date'    => [new CheckSubmissionDate($this->get('type'), $this->get('start_date'))],
            'lg_ids'             => ['nullable', 'array', new CheckAssignedUserStatusForLg()],
            'ministry_ids'       => ['nullable', 'array', new CheckAssignedUserStatusForMinistry()],
            'ministry_office_ids'=> ['nullable', 'array', new CheckAssignedUserStatusForMinistryOffice()],
            'select_all'        => ['nullable', new SelectAllInformationRules()]
//            'district_id'        => ['nullable'],
//            'province_id'        => ['nullable'],
//            'ministry_id'        => ['nullable'],
//            'select_all'         => ['nullable', new CheckSelectAllCondition($this->get('district_id'),$this->get('province_id'),$this->get('ministry_id'))]
        ];
    }

}
