<?php

namespace App\Rules\Api;

use App\Models\LocalGovernment;
use App\Models\Ministry;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class CheckIfLgsOrMinistries implements Rule
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
     * @param $agencyIds
     * @return bool
     */
    public function passes($attribute, $agencyIds)
    {
        if (!in_array($this->userType, ['ministry', 'local_government'])) {
            $this->errorMessage = 'User type does not match';
            return false;
        }

        if ($this->userType == 'ministry') {
            $this->errorMessage = 'Ministries do not exist';
            $agencyCount = Ministry::whereIn('id', $agencyIds)->count();
            return $agencyCount == count($agencyIds);
        }

        $this->errorMessage = 'Local governments do not exist';
        $agencyCount = LocalGovernment::whereIn('id', $agencyIds)->count();
        return $agencyCount == count($agencyIds);
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
