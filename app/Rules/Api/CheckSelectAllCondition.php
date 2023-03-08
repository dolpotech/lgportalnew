<?php

namespace App\Rules\Api;

use Illuminate\Contracts\Validation\Rule;

class CheckSelectAllCondition implements Rule
{
    private $districtId;
    private $provinceId;
    private $ministryId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($districtId, $provinceId, $ministryId)
    {
        $this->districtId = $districtId;
        $this->provinceId = $provinceId;
        $this->ministryId = $ministryId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $selectAll
     * @return bool
     */
    public function passes($attribute, $selectAll)
    {
        if (!$selectAll)
        {
            return true;
        }
        if ($selectAll == getLgByDistrict()){
            if (!$this->districtId){
                return false;
            }
        }
        if ($selectAll == getLgByProvince()){
            if (!$this->provinceId){
                return false;
            }
        }
        if ($selectAll == getAllMinistryOfficeByMinistryId()){
            if (!$this->provinceId){
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
        return 'Please provide required select all values';
    }
}
