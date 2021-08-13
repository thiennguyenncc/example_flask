<?php

namespace Bachelor\Domain\MasterDataManagement\Coupon\Interfaces;

use Bachelor\Domain\MasterDataManagement\Coupon\Models\Coupon;

interface CouponRepositoryInterface
{
    /**
     * @param int $id
     * @return Coupon|null
     */
    public function getCouponById(int $id): ?Coupon;

    /**
     * @param string $column
     * @param mixed $value
     * @return Coupon|null
     */
    public function getCouponByCouponType(string $couponType): ?Coupon;

    /**
     * @param Coupon $coupon
     * @return Coupon
     */
    public function save(Coupon $coupon): Coupon;
}
