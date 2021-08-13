<?php

namespace Bachelor\Application\User\Services\Interfaces;

interface UserCouponApplicationServiceInterface
{
    /**
     * Retrieve all the user coupons
     *
     * @return UserCouponApplicationServiceInterface
     */
    public function getAllUserCoupon() : UserCouponApplicationServiceInterface;

    /**
     * Issue user coupon
     *
     * @param string $couponType
     * @return UserCouponApplicationServiceInterface
     */
    public function issueUserCoupon(string $couponType) : UserCouponApplicationServiceInterface;

    /**
     * Purchase user coupon
     *
     * @param array $params
     * @return UserCouponApplicationServiceInterface
     */
    public function purchaseUserCoupon(string $couponType) : UserCouponApplicationServiceInterface;

    /**
     * Return user coupon
     *
     * @param int $userCouponId
     * @return UserCouponApplicationServiceInterface
     */
    public function returnUserCoupon(int $userCouponId) : UserCouponApplicationServiceInterface;

    /**
     * Discard user coupons
     *
     * @return UserCouponApplicationServiceInterface
     */
    public function discardUserCoupon() : UserCouponApplicationServiceInterface;

    /**
     * Apply user coupon
     *
     * @param int $datingDayId
     * @param string $couponType
     * @return UserCouponApplicationServiceInterface
     */
    public function applyUserCoupon(int $datingDayId, string $couponType) : UserCouponApplicationServiceInterface;

    /**
     * Exchange user coupon
     *
     * @param array $params
     * @return UserCouponApplicationServiceInterface
     */
    public function exchangeUserCoupon(string $couponType) : UserCouponApplicationServiceInterface;

    /**
     * Format response data
     *
     * @return array
     */
    public function handleApiResponse() : array ;
}
