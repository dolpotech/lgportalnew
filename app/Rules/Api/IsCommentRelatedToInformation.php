<?php

namespace App\Rules\Api;

use App\Models\InformationComment;
use App\Models\LocalGovernment;
use App\Models\Ministry;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class IsCommentRelatedToInformation implements Rule
{
    protected $informationId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($informationId)
    {
        $this->informationId = $informationId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param $agencyIds
     * @return bool
     */
    public function passes($attribute, $commentId)
    {
        return InformationComment::where('information_id', $this->informationId)
            ->where('id', $commentId)
            ->count();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Comment is not associated with information collection';
    }
}
