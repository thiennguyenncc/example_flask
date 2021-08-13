<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Api;

use App\Http\Requests\ApplyUserCoupon;
use Bachelor\Application\User\Services\Interfaces\UserCouponApplicationServiceInterface;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * Class UserCouponController
 * @package Bachelor\Port\Primary\WebApi\Controllers\Api
 *
 * @group User Coupon
 */
class UserCouponController extends BaseController
{
    /**
     * Get all the coupons related to the user
     *
     * @param UserCouponApplicationServiceInterface $userCouponService
     * @return JsonResponse
     */
    public function index(UserCouponApplicationServiceInterface $userCouponService)
    {
        // Fetch all user coupons
        $response = $userCouponService->getAllUserCoupon()->handleApiResponse();

        // Set api response
        $this->setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);

    }

    /**
     * Issue a new user coupon
     *
     * @param UserCouponApplicationServiceInterface $userCouponService
     * @param string $type
     * @return JsonResponse
     */
    public function issueCoupon(UserCouponApplicationServiceInterface $userCouponService, string $couponType)
    {
        DB::beginTransaction();
        try {
            // Create new user coupon
            $response = $userCouponService->issueUserCoupon($couponType)->handleApiResponse();

            // Set api response
            $this->setResponse($response['status'], $response['message'], $response['data']);
            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();
            throw $exception;

        }

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);

    }

    /**
     * Purchase a new user coupon
     *
     * @param UserCouponApplicationServiceInterface $userCouponService
     * @param string $type
     * @return JsonResponse
     */
    public function purchaseCoupon(UserCouponApplicationServiceInterface $userCouponService, string $couponType)
    {
        DB::beginTransaction();
        try {
            // Create new user coupon
            $response = $userCouponService->purchaseUserCoupon($couponType)->handleApiResponse();

            // Set api response
            $this->setResponse($response['status'], $response['message'], $response['data']);
            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();
            throw $exception;

        }

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);

    }

    /**
     * Return the specified user coupon
     *
     * @param UserCouponApplicationServiceInterface $userCouponService
     * @param int $userCoupon
     * @return JsonResponse
     */
    public function returnUserCoupon(UserCouponApplicationServiceInterface $userCouponService, int $userCouponId)
    {
        DB::beginTransaction();
        try
        {
            // Update user coupon
            $response = $userCouponService->returnUserCoupon($userCouponId)->handleApiResponse();

            // Set api response
            $this->setResponse($response['status'], $response['message'], $response['data']);

            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();
            throw $exception;

        }

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * Discard user coupon
     *
     * @param UserCouponApplicationServiceInterface $userCouponService
     * @return JsonResponse
     */
    public function discardUserCoupon(UserCouponApplicationServiceInterface $userCouponService)
    {
        DB::beginTransaction();
        try
        {
            // Update user coupon
            $response = $userCouponService->discardUserCoupon()->handleApiResponse();

            // Set api response
            $this->setResponse($response['status'], $response['message'], $response['data']);

            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();

            throw $exception;

        }

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);

    }

    /**
     * Apply user coupon
     *
     * @param ApplyUserCoupon $request
     * @param UserCouponApplicationServiceInterface $userCouponService
     * @param string $couponType
     * @return JsonResponse
     */
    public function applyUserCoupon(ApplyUserCoupon $request, UserCouponApplicationServiceInterface $userCouponService, string $couponType)
    {
        DB::beginTransaction();
        try
        {
            $response = $userCouponService->applyUserCoupon($request->get('datingDayId'), $couponType)->handleApiResponse();

            $this->setResponse($response['status'], $response['message'], $response['data']);

            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();

            throw $exception;

        }

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);

    }

    /**
     * Exchange the user coupon
     *
     * @param UserCouponApplicationServiceInterface $userCouponService
     * @return JsonResponse
     */
    public function exchangeUserCoupon(UserCouponApplicationServiceInterface $userCouponService,string $couponType)
    {
        DB::beginTransaction();
        try
        {
            // Exchange coupon
            $response = $userCouponService->exchangeUserCoupon($couponType)->handleApiResponse();

            // Set api response
            $this->setResponse($response['status'], $response['message'], $response['data']);

            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();

            throw $exception;

        }

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);

    }
}
