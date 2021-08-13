<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\UserPaymentCustomer\Trait;

use Bachelor\Port\Secondary\Database\PaymentManagement\UserPaymentCustomer\Factory\UserPaymentCustomerFactory;

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
        return new UserPaymentCustomerFactory();
    }
}
