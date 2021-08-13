<?php

namespace Bachelor\Application\Admin\Services\Interfaces;

interface AdminCouponServiceInterface
{
    /**
     * Issue coupon
     *
     * @param int $userId
     * @param int[] $couponTypes
     * @return AdminCouponServiceInterface
     */
    public function issueCoupons($userId, $couponTypes): AdminCouponServiceInterface;

    /**
     * Format response data
     *
     * @return array
     */
    public function handleApiResponse() : array;
}
