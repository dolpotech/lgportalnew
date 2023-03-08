<?php

namespace App\Rules\Api;

use App\HelperClasses\Traits\AuthHelper;
use App\Models\InformationReceiver;
use App\Models\LocalGovernment;
use Illuminate\Contracts\Validation\Rule;

class CheckStartDate implements Rule
{
    protected $infoType;

    public function __construct($infoType)
    {
        $this->infoType = $infoType;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $startDate
     * @return bool
     */
    public function passes($attribute, $startDate)
    {
        if ($this->infoType == getCircularInfoType()) {
            return true;
        }

        return isValidDate($startDate);
    }


    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Start Date is not valid';
    }
}
