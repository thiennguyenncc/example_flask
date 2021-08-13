<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserCoupon\Traits;

use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Bachelor\Port\Secondary\Database\DatingManagement\DatingDay\ModelDao\DatingDay;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Coupon\ModelDao\Coupon;

trait UserCouponRelationshipTrait
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
     * Get the user to which the user coupon belongs to
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user to which the user coupon belongs to
     *
     * @return mixed
     */
    public function datingDay()
    {
        return $this->belongsTo(DatingDay::class);
    }
}
