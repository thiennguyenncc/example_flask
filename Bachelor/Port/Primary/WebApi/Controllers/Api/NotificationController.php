<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Api;

use App\Http\Requests\MarkAsReadRequest;
use Bachelor\Application\User\Services\NotificationService;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Illuminate\Http\JsonResponse;

class NotificationController extends BaseController
{
    /**
     * @param MarkAsReadRequest $request
     * @param NotificationService $notificationService
     * @return JsonResponse
     *
     * @bodyParam mobileNumber string required The mobile number of the user who wants to migrate the account. Example: 09272663636
     * @response 302 redirect to social-login for re-authentication
     * @response 512 {
     *      "message":"Error Encountered while migrating account in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/MigrationController.php at 52 due to `Exception message`",
     *      "data":[]
     *  }
     */
    public function markEmailNotificationAsRead(MarkAsReadRequest $request, NotificationService $notificationService)
    {
        $response = $notificationService->markEmailNotificationAsRead($request->get('code'));

        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }
}
