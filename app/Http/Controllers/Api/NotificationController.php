<?php

namespace App\Http\Controllers\Api;

use App\HelperClasses\Traits\ApiResponse;
use App\HelperClasses\Traits\AuthHelper;
use App\Http\Controllers\Controller;
use App\Services\Api\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ApiResponse, AuthHelper;

    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Get Ministry Notification
     *
     * @return mixed
     */
    public function getMinistryNotification()
    {
        $notifications = $this->notificationService->getministryNotification();
        if ($notifications->count() == 0)
        {
            return $this->sendApiSuccessResponse([],'Ministry Notification is empty','');
        }

        return $this->sendApiSuccessResponse($notifications,'Ministry Notification retrieved successfully');
    }

    /**
     * Get Lg Notification
     *
     * @return mixed
     */
    public function getLgNotification()
    {
        $notifications = $this->notificationService->getLgNotification();
        if ($notifications->count() == 0)
        {
            return $this->sendApiSuccessResponse([],'Lg Notification is empty','');
        }

        return $this->sendApiSuccessResponse($notifications,'Lg Notification retrieved successfully');
    }

    /**
     * Get Ministry Office Notification
     *
     * @return mixed
     */
    public function getMinistryOfficeNotification()
    {
        $notifications = $this->notificationService->getMinistryOfficeNotification();

        if ($notifications->count() == 0)
        {
            return $this->sendApiSuccessResponse([],'Ministry Office Notification is empty','');
        }

        return $this->sendApiSuccessResponse($notifications,'Ministry Office Notification retrieved successfully');
    }

}
