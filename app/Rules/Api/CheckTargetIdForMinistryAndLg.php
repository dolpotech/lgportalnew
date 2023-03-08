<?php

namespace App\Rules\Api;

use App\Models\LocalGovernment;
use App\Models\Ministry;
use Illuminate\Contracts\Validation\Rule;

class CheckTargetIdForMinistryAndLg implements Rule
{
    protected $userType;
    protected $errorMessage;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($userType)
    {
        $this->userType = $userType;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $designationId
     * @return bool
     */
    public function passes($attribute, $designationId)
    {
        if (!in_array($this->userType, ['ministry', 'local_government'])) {
            $this->errorMessage = 'User type does not match';
            return false;
        }

        if ($this->userType == 'ministry') {
            $this->errorMessage = 'Ministry does not exists';
            return Ministry::where('id', $designationId)->exists();
        }

        $this->errorMessage = 'Local Government does not exists';
        return LocalGovernment::where('id', $designationId)->exists();
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
