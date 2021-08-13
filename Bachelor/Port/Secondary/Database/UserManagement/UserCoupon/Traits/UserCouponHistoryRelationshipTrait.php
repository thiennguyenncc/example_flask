<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserCoupon\Traits;

use Bachelor\Port\Secondary\Database\MasterDataManagement\Coupon\ModelDao\Coupon;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Bachelor\Port\Secondary\Database\UserManagement\UserCoupon\ModelDao\UserCoupon;

trait UserCouponHistoryRelationshipTrait
{
    /**
     * Get related coupon data
     *
     * @return mixed
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Get related user coupon data
     *
     * @return mixed
     */
    public function userCoupon()
    {
        return $this->belongsTo(UserCoupon::class);
    }

    /**
     * Get the user data to which this coupon history belongs to
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
