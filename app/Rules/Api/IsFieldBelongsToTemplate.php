<?php

namespace App\Rules\Api;

use App\HelperClasses\Traits\AuthHelper;
use App\Models\InformationCollection;
use App\Models\TemplateField;
use Illuminate\Contracts\Validation\Rule;


class IsFieldBelongsToTemplate implements Rule
{
    use AuthHelper;
    private $fieldId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($fieldId)
    {
        $this->fieldId = $fieldId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $informationId
     * @return int
     */
    public function passes($attribute, $informationId)
    {
        $template = InformationCollection::find($informationId);
        $template = $template->template_id;
        $fields = TemplateField::where('template_id', $template)->pluck('id')->toArray();
        if (in_array($this->fieldId, $fields))
        {
            return true;
        }
        else
            return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Field not belong to this information';
    }
}
