<?php

namespace Bachelor\Application\User\Factories;

use Bachelor\Port\Secondary\Database\MasterDataManagement\Coupon\ModelDao\Coupon;

class CouponFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Coupon::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition ()
    {
        return [
            'name' => 'dating'
        ];
    }
}
