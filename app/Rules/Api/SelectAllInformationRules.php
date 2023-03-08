<?php

namespace App\Rules\Api;

use App\HelperClasses\Traits\AuthHelper;
use App\Models\District;
use App\Models\Ministry;
use App\Models\Province;
use Illuminate\Contracts\Validation\Rule;

class SelectAllInformationRules implements Rule
{
    use AuthHelper;
    protected $message;

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $lgIds
     * @return bool
     */
    public function passes($attribute, $selectAllKey)
    {
        if (in_array($selectAllKey, selectAllInformationKeys())) {

            if ($selectAllKey == selectAllLgByDistrictKey()) {
                if (District::where('id', request()->get('district_id'))->exists()) {
                    return true;
                }
                $this->message = 'District Id does not match';
                return false;
            }

            if ($selectAllKey == selectAllLgByProvinceKey()) {
                if (Province::where('id', request()->get('province_id'))->exists()) {
                    return true;
                }
                $this->message = 'Province Id does not match';
                return false;
            }

            if ($selectAllKey == selectAllMinistryByProvince()) {
                if (Province::where('id', request()->get('province_id'))->exists()) {
                    return true;
                }
                $this->message = 'Province Id does not match';
                return false;
            }

            if ($selectAllKey == selectAllMinistryOfficeByProvince()) {
                if (Province::where('id', request()->get('province_id'))->exists()) {
                    return true;
                }
                $this->message = 'Province Id does not match';
                return false;
            }

            if ($selectAllKey == selectAllMinistryOfficeByMinistry()) {
                if (Ministry::where('id', request()->get('ministry_id'))->exists()) {
                    return true;
                }
                $this->message = 'Ministry Id does not match';
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
        return $this->message;
    }
}
