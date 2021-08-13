<?php


namespace Bachelor\Port\Secondary\Database\UserManagement\UserCoupon\Factory;



use Bachelor\Port\Secondary\Database\UserManagement\UserCoupon\ModelDao\UserCoupon;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserCouponFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserCoupon::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [];
    }
}
