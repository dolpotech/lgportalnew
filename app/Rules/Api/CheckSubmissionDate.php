<?php

namespace App\Rules\Api;

use App\HelperClasses\Traits\AuthHelper;
use App\Models\InformationReceiver;
use App\Models\LocalGovernment;
use Illuminate\Contracts\Validation\Rule;

class CheckSubmissionDate implements Rule
{
    protected $infoType;
    private $startDate;

    public function __construct($infoType, $startDate)
    {
        $this->infoType = $infoType;
        $this->startDate = $startDate;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $submissionDate
     * @return bool
     */
    public function passes($attribute, $submissionDate)
    {
        if ($this->infoType == getCircularInfoType()) {
            return true;
        }

        $todayDate = date("Y-m-d");

        if ($submissionDate < $todayDate)
        {
            return false;
        }

        if ($submissionDate < $this->startDate)
        {
            return false;
        }

        return isValidDate($submissionDate);
    }


    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Submission Date is not valid';
    }
}
