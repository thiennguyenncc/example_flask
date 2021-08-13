<?php


namespace Bachelor\Port\Secondary\Database\MasterDataManagement\Coupon\Traits;


use Bachelor\Port\Secondary\Database\MasterDataManagement\Coupon\Factory\CouponFactory;

Trait HasFactory
{
    public static function factory(...$parameters)
    {
        return new CouponFactory();
    }
}
