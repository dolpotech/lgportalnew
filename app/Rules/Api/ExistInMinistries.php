<?php

namespace App\Rules\Api;

use App\Models\LocalGovernment;
use App\Models\Ministry;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class ExistInMinistries implements Rule
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
     * @param $ministryIds
     * @return bool
     */
    public function passes($attribute, $ministryIds)
    {
        if (count($ministryIds) == 0) {
            $this->errorMessage = 'Ministries do not exist';
            return true;
        }

        $ministryCount = Ministry::whereIn('id', $ministryIds)->count();
        return $ministryCount == count($ministryIds);

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
