<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Api;

use App\Http\Requests\User\UserProfile\UserEmailUpdateRequest;
use App\Http\Requests\UserReactivedOrReApprovedRequest;
use Bachelor\Application\User\Services\UserPreferenceService;
use Bachelor\Application\User\Services\UserProfileService;
use Bachelor\Application\User\Services\UserService;
use Bachelor\Domain\UserManagement\User\Traits\RegistrationDataExtractorTrait;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Http\Requests\UpdateUserPreferenceRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Throwable;

/*
 * Class UserController
 * @package Bachelor\Port\Primary\WebApi\Controllers\Api
 *
 * @group User
 */

class UserController extends BaseController
{
    use RegistrationDataExtractorTrait;

    public function index(UserService $userService)
    {
        $this->data = $userService->getGlobalInfo(Auth::user()->getDomainEntity());

        return ApiResponseHandler::jsonResponse(Response::HTTP_OK, __('api_messages.successful'), $this->data);
    }

    /**
     * save request to Re-activated or Re-approved
     *
     * @param UserReactivedOrReApprovedRequest $request
     * @param UserService $userService
     * @return JsonResponse
     */
    public function requestToReactivateOrReapproved(UserReactivedOrReApprovedRequest $request, UserService $userService): JsonResponse
    {
        DB::beginTransaction();
        try {
            $response = $userService->reactivateOrReapproveUser(Auth::user()->getDomainEntity(), $request->all())->handleApiResponse();
            // set api response
            DB::commit();
            self::setResponse($response['status'], $response['message'], $response['data']);
        } catch (Exception $exception) {

            DB::rollback();
            throw $exception;
        }

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }

    /**
     * Get profile info
     *
     * @param UserProfileService $userService
     * @return JsonResponse
     */
    public function getMypageInfo(UserService $userService): JsonResponse
    {
        // Fetch user info
        $response = $userService->getMypageInfo(Auth::user()->getDomainEntity())->handleApiResponse();

        // set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * Get profile info
     *
     * @param UserProfileService $userService
     * @return JsonResponse
     */
    public function getProfileInfo(UserProfileService $userProfileService): JsonResponse
    {
        // Fetch user info
        $response = $userProfileService->getProfileInfo(Auth::user()->getDomainEntity())->handleApiResponse();

        // set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * Get preference info
     *
     * @param UserPreferenceService $userPreferenceService
     * @return JsonResponse
     */
    public function getPreferenceInfo(UserPreferenceService $userPreferenceService): JsonResponse
    {
        // Fetch user info
        $response = $userPreferenceService->getPreferenceInfo(Auth::user()->getDomainEntity())->handleApiResponse();

        // set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * Update User Profile Information
     *
     * @param UserProfileService $userProfileService
     * @param Request $request
     * @return JsonResponse
     */
    public function updateProfile(UserProfileService $userProfileService, Request $request): JsonResponse
    {
        $response =  $userProfileService->updateProfile(Auth::user()->getDomainEntity(), $request->all())->handleApiResponse();

        // set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }

    /**
     * Update User Email
     *
     * @param UserService $userService
     * @param UserEmailUpdateRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function updateEmail(UserService $userService, UserEmailUpdateRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $response = $userService->updateEmail(Auth::user()->getDomainEntity(), $request->get('email'));
            $this->setResponse($response['status'], $response['message'], $response['data']);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();
            throw $exception;
        }

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * Update User Profile Information
     *
     * @param UserPreferenceService $userPreferenceService
     * @param Request $request
     * @return JsonResponse
     */
    public function updatePreference(UserPreferenceService $userPreferenceService, Request $request): JsonResponse
    {
        // Retrieve area data
        $response =  $userPreferenceService->updatePreference(Auth::user()->getDomainEntity(), $request->all())->handleApiResponse();

        // set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }

    /**
     * Get current server time global
     *
     * @return JsonResponse
     *
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": []
     * }
     * @response 512 {
     *   "message": "error",
     *   "data": []
     * }
     */
    public function getCurrentServerTime(){
        try {
            $this->data['current_server_time'] = Carbon::now()->toDateTimeString();
        } catch (Exception $exception) {
            DB::rollback();
            throw $exception;
        }
        return ApiResponseHandler::jsonResponse(Response::HTTP_OK, __('api_messages.successful'), $this->data);
    }
}
