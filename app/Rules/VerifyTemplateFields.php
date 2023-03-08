<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class VerifyTemplateFields implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $fields)
    {
        foreach ($fields as $field) {

            $type = $field['type'] ?? '';

            if ($type !== '') {
                if (in_array($type, ['radio', 'select', 'checkbox'])) {

                    if (!isset($field['options']) || !is_array($field['options'])) {
                        return false;
                    } else {
                        foreach ($field['options'] as $option) {
                            if (!isset($option['label']) || !isset($option['value'])) {
                                return false;
                            }
                        }
                    }
                }
            }

            if (
                !isset($field['name']) || $field['name'] == ''
                || !isset($field['type']) || !in_array($field['type'], getFieldTypes())
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid Form Field Detected';
    }
}
