<?php

namespace App\Rules\Api;

use App\Models\LocalGovernment;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class ExistInLgs implements Rule
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
     * @param $LgsIds
     * @return bool
     */
    public function passes($attribute, $LgsIds)
    {
        if (count($LgsIds) == 0) {
            $this->errorMessage = 'Local government do not exist';
            return true;
        }

        $lgCount = LocalGovernment::whereIn('id', $LgsIds)->count();
        return $lgCount == count($LgsIds);

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
