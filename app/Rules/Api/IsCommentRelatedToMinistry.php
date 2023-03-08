<?php

namespace App\Rules\Api;

use App\HelperClasses\Traits\AuthHelper;
use App\Models\InformationComment;
use Illuminate\Contracts\Validation\Rule;

class IsCommentRelatedToMinistry implements Rule
{
    use AuthHelper;

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
     * @param $commentId
     * @return bool
     */
    public function passes($attribute, $commentId)
    {
        $commentSection = InformationComment::join('information_collection', 'information_comments.information_id', 'information_collection.id')
            ->where('information_comments.id', $commentId)
            ->first();

        if (!$commentSection) {
            return false;
        }

        if ($commentSection->assigner_id == $this->getAuthId()) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Comment is not associated with ministry admin';
    }
}
