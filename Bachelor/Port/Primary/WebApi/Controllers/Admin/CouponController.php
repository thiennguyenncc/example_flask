<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Admin;

use App\Http\Requests\AdminIssueCouponRequest;
use Bachelor\Application\Admin\Services\Interfaces\AdminCouponServiceInterface;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Illuminate\Http\JsonResponse;

/**
 * @group Coupon
 */
class CouponController extends BaseController
{
    /**
     * Issue coupon to user
     *
     * @param AdminIssueCouponRequest $request
     * @param AdminCouponServiceInterface $couponService
     * @return JsonResponse
     *
     * @bodyParam userId integer required Id of user
     * @bodyParam couponTypes string[] required Coupon type, can be ["dating", "bachelor"]. Example: ["dating"]
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": []
     * }
     * @response 512 {
     *     "message":"Error encountered while issuing user coupon."
     *     "data":[]
     * }
     */
    public function issueCoupon(AdminIssueCouponRequest $request, AdminCouponServiceInterface $couponService)
    {
        $response = $couponService->issueCoupons(
                $request->get('userId'),
                $request->get('couponTypes')
        )->handleApiResponse();

        self::setResponse($response['status'], $response['message'], $response['data']);
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }
}
