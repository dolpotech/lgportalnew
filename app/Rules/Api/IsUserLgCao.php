<?php

namespace App\Rules\Api;

use App\HelperClasses\Traits\AuthHelper;
use Illuminate\Contracts\Validation\Rule;


class IsUserLgCao implements Rule
{
    use AuthHelper;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $fieldId
     * @return int
     */
    public function passes($attribute, $fieldId)
    {
        return $this->isAuthLgCao();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'User is not local government cao';
    }
}
