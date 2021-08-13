<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Api;

use Bachelor\Application\User\Services\CancelDeactivateAccountService;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserAccountController extends BaseController
{

    /**
     * @param Request $request
     * @param CancelDeactivateAccountService $cancelDeactivateAccountService
     * @return JsonResponse
     *
     * @response 200 {
     *    "message": "Successfully",
     *    "data": []
     * }
     * @response 403 {
     *    "message": "Can not cancel or deactivate account",
     *    "data": []
     *  }
     */
    public function cancelAccount(Request $request, CancelDeactivateAccountService $cancelDeactivateAccountService): JsonResponse
    {
        $cancelDeactivateAccountService->processCancel(Auth::user()->getDomainEntity(), $request->all());

        $this->setResponse(Response::HTTP_OK, __('api_messages.successful'), []);

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * @param Request $request
     * @param CancelDeactivateAccountService $cancelDeactivateAccountService
     * @return JsonResponse
     *
     * @response 200 {
     *    "message": "Successfully",
     *    "data": []
     * }
     * @response 403 {
     *    "message": "Can not cancel or deactivate account",
     *    "data": []
     *  }
     */
    public function deactivateAccount(Request $request, CancelDeactivateAccountService $cancelDeactivateAccountService): JsonResponse
    {
        $cancelDeactivateAccountService->processDeactivate(Auth::user()->getDomainEntity(), $request->all());

        $this->setResponse(Response::HTTP_OK, __('api_messages.successful'), []);

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * @param CancelDeactivateAccountService $cancelDeactivateAccountService
     * @return JsonResponse
     *
     * @response 200 {
     *    "message": "Successfully",
     *    "data": []
     * }
     */
    public function validateBeforeCancelDeactivateAccount(CancelDeactivateAccountService $cancelDeactivateAccountService): JsonResponse
    {
        $resultValidate = $cancelDeactivateAccountService->validateCancelDeactivateAccount(Auth::user()->getDomainEntity());

        return ApiResponseHandler::jsonResponse(Response::HTTP_OK, __('api_messages.successful'), $resultValidate);
    }
}
