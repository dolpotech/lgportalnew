<?php

namespace App\Rules\Api;

use App\Models\MinistryOffices;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class ExistInMinistryOffices implements Rule
{
    protected $errorMessage;

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
     * @param $MinistryOfficeIds
     * @return bool
     */
    public function passes($attribute, $MinistryOfficeIds)
    {
        if (count($MinistryOfficeIds) == 0) {
            $this->errorMessage = 'Ministry offices do not exist';
            return true;
        }

        $ministryOfficeCount = MinistryOffices::whereIn('id', $MinistryOfficeIds)->count();
        return $ministryOfficeCount == count($MinistryOfficeIds);

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->errorMessage;
    }
}
