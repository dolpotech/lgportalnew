<?php

namespace App\Http\Controllers\Api;

use App\HelperClasses\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\InformationCollection\CreateNewInformationCollectionRequest;
use App\Http\Requests\Api\InformationComment\CreateInformationCommentRequest;
use App\Http\Requests\Api\InformationComment\GetCommentListForLgRequest;
use App\Http\Requests\Api\InformationComment\ReplyInformationCommentRequest;
use App\Services\Api\InformationCollectionService;
use App\Services\Api\InformationCommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class InformationCommentController extends Controller
{
    use ApiResponse;

    private $commentService;


    public function __construct(InformationCommentService $commentService)
    {
        $this->commentService = $commentService;
    }


    /**
     * Get Comment List for Lg Ministry
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getCommentListForLgMinistry(Request $request): JsonResponse
    {
        $comments = $this->commentService->getInformationCommentForLgMinistry((int) $request->get('comment_id'));

        return $this->sendApiSuccessResponse($comments, 'Comments fetched Successfully');
    }


    /**
     * Get Comment List for Lg Admin
     *
     * @param GetCommentListForLgRequest $request
     * @return JsonResponse
     */
    public function getCommentListForLgAdmin(GetCommentListForLgRequest $request): JsonResponse
    {
        $comments = $this->commentService->getInformationCommentForLgAdmin((int) $request->get('information_id'));

        return $this->sendApiSuccessResponse($comments, 'Comments fetched Successfully');
    }


    /**
     * Create Comment By Lg Admin
     *
     * @param CreateInformationCommentRequest $request
     * @return JsonResponse
     */
    public function createCommentOnInformation(CreateInformationCommentRequest $request): JsonResponse
    {
        $comment = $this->commentService->createCommentByInformation(
            (int) $request->get('information_id'),
            (string) $request->get('comment')
        );

        return $this->sendApiSuccessResponse($comment, 'Comment created Successfully');
    }


    /**
     * Get Comment Users List
     *
     * @return mixed
     */
    public function getCommentUsersListForMinistry(Request $request)
    {
        $users = $this->commentService->getCommentUsersListForMinistry($request->get('information_id'));

        return $this->sendApiSuccessResponse($users, 'Comment Users retrieved Successfully');
    }


    /**
     * Reply Information Comment By Ministry Admin
     *
     * @param ReplyInformationCommentRequest $request
     * @return JsonResponse
     */
    public function replyInformationCommentByMinistryAdmin(ReplyInformationCommentRequest $request): JsonResponse
    {
        $comment = $this->commentService->replyCommentByMinistryAdmin(
            (int) $request->get('comment_id'),
            (string) $request->get('message')
        );

        return $this->sendApiSuccessResponse($comment, 'Comment Reply sent Successfully');
    }

}
