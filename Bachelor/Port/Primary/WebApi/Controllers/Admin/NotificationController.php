<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Admin;

use App\Http\Requests\AdminBulkMessageRequest;
use App\Http\Requests\AdminSearchNotificationsRequest;
use App\Http\Requests\CreateNotification;
use App\Http\Requests\SendNotification;
use App\Http\Requests\UpdateNotification;
use Bachelor\Application\Admin\Services\AdminNotificationService;
use Bachelor\Application\Admin\Services\Interfaces\AdminNotificationServiceInterface;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Class NotificationController
 * @package Bachelor\Port\Primary\WebApi\Controllers\Admin
 *
 * @group Admin Notification
 */
class NotificationController extends BaseController
{
    /**
     * Get notifications
     *
     * @param AdminNotificationServiceInterface $notificationService
     * @param AdminSearchNotificationsRequest $request
     * @return JsonResponse
     */
    public function index(
        AdminNotificationServiceInterface $notificationService,
        AdminSearchNotificationsRequest $request
    ): JsonResponse
    {
        $response = $notificationService->retrieveNotificationsByConditions($request->get('type'), $request->get('search'))
            ->handleApiResponse();

        // Set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }

    /**
     * Update an existing notification
     *
     * @param UpdateNotification $updateNotification
     * @param AdminNotificationServiceInterface $notificationService
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateNotification $updateNotification, AdminNotificationServiceInterface $notificationService, int $id): JsonResponse
    {
        $response = $notificationService->updateNotification($id, $updateNotification->all())
            ->handleApiResponse();

        // Set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }

    /**
     * Send notification to users via user ids
     *
     * @param AdminNotificationServiceInterface $notificationService
     * @param string $id
     * @return string
     */
    public function read(AdminNotificationServiceInterface $notificationService, $id)
    {
        if ($id)
            // Mark notification as read
            $notificationService->markAsRead($id);

        // Return base64 encode image transparent 1x1 pixel.
        return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';
    }

    public function sendBulkMessage(AdminBulkMessageRequest $request, AdminNotificationService $notificationService)
    {
        $response = $notificationService->sendBulkMessage(
            $request->file('file')->getRealPath()
        )->handleApiResponse();

        self::setResponse($response['status'], $response['message'], $response['data']);
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }
}
