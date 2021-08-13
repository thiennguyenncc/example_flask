<?php


namespace Bachelor\Port\Secondary\Database\MasterDataManagement\Coupon\Factory;



use Bachelor\Port\Secondary\Database\MasterDataManagement\Coupon\ModelDao\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{
    protected $model = Coupon::class;
    public function definition()
    {
        return [];
    }
}
