<?php


namespace App\Services\Api;


use App\HelperClasses\Traits\AuthHelper;
use App\Models\InformationCollection;
use App\Models\InformationComment;
use App\Models\InformationCommentList;
use Symfony\Polyfill\Intl\Idn\Info;


class InformationCommentService
{
    use AuthHelper;


    /**
     * Get Information Comment For Lg Ministry
     *
     * @param int $commentId
     * @return array
     */
    public function getInformationCommentForLgMinistry(int $commentId): array
    {
        $comments = InformationCommentList::with('commenter')
            ->where('information_comment_id', $commentId)
            ->orderBy('created_at')
            ->get();

        $hasMessage = 0;

        if ($comments->count() > 0) {
            $lastComment = $comments->last();

            $commentSection = InformationComment::find($commentId);

            if ($lastComment->user_id == $commentSection->commenter_id) {
                $hasMessage = 1;
            }
        }

        return [
            'comments'   => $comments,
            'has_message' => $hasMessage
        ];
    }



    /**
     * Get Information Comment for Lg Admin
     *
     * @param int $informationId
     * @return array
     */
    public function getInformationCommentForLgAdmin(int $informationId)
    {
        $commentSection = InformationComment::where('information_id', $informationId)
            ->where('commenter_id', $this->getAuthId())
            ->first();

        if (!$commentSection) {
            $commentSection = InformationComment::create([
                'information_id'    => $informationId,
                'commenter_id'      => $this->getAuthId()
            ]);
        }

        $comments = InformationCommentList::with('commenter')
            ->where('information_comment_id', $commentSection->id)
            ->orderBy('created_at')
            ->get();

        $hasReplied = 0;

        if ($comments->count() > 0) {
            $information = InformationCollection::find($informationId);
            $lastComment = $comments->last();

            if ($lastComment->user_id == $information->assigner_id) {
                $hasReplied = 1;
            }
        }

        return [
            'comment_id' => $commentSection->id,
            'comments'   => $comments,
            'has_replied' => $hasReplied
        ];
    }


    /**
     * Create Information Comment on Information
     *
     * @param int $informationId
     * @param string $comment
     * @return mixed
     */
    public function createCommentByInformation(int $informationId, string $comment)
    {
        return InformationComment::create([
            'information_id'        => $informationId,
            'commenter_id'          => $this->getAuthId(),
            'comment'               => $comment,
        ]);
    }


    /**
     * Reply Message By Ministry Admin
     *
     * @param int $commentId
     * @param string $message
     * @return mixed
     */
    public function replyCommentByMinistryAdmin(int $commentId,  string $message)
    {
        if (InformationComment::where('id', $commentId)->exists()){
            return InformationComment::where('id', $commentId)->
            update([
                'reply' => $message
            ]);
        }
        return false;
    }


    /**
     * Get Comment User List
     *
     * @return mixed
     */
    public function getCommentUsersListForMinistry(int $informationId)
    {
        return InformationComment::select('*', 'information_comments.id as comment_id')
            ->with('commenter')
            ->withCount('comments')
            ->where('information_id', $informationId)
            ->get();
    }


}
