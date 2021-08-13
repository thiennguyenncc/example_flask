<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\UserPaymentCustomer\Factory;
use Bachelor\Port\Secondary\Database\PaymentManagement\UserPaymentCustomer\ModelDao\UserPaymentCustomer;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserPaymentCustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserPaymentCustomer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition () : array
    {
        return [];
    }

}
