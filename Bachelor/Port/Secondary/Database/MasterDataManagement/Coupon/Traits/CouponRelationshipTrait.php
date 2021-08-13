<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\Coupon\Traits;

use Bachelor\Port\Secondary\Database\UserManagement\UserCoupon\ModelDao\UserCoupon;
use Bachelor\Port\Secondary\Database\UserManagement\UserCoupon\ModelDao\UserCouponHistory;

trait CouponRelationshipTrait
{
    /**
     * Get all the user coupon data
     *
     * @return mixed
     */
    public function userCoupon()
    {
        return $this->hasMany(UserCoupon::class);
    }

    /**
     * Get all the user coupon histories data
     *
     * @return mixed
     */
    public function userCouponHistories()
    {
        return $this->hasMany(UserCouponHistory::class);
    }
}
