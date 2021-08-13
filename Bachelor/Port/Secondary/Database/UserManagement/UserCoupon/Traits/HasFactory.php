<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserCoupon\Traits;

use Bachelor\Port\Secondary\Database\UserManagement\UserCoupon\Factory\UserCouponFactory;

trait HasFactory
{
    /**
     * Get a new factory instance for the model.
     *
     * @param  mixed  $parameters
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public static function factory(...$parameters)
    {
        return new UserCouponFactory();
    }
}
