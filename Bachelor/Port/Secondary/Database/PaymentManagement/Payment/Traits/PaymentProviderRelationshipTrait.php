<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\Payment\Traits;

use Bachelor\Port\Secondary\Database\PaymentManagement\UserPaymentCustomer\ModelDao\UserPaymentCustomer;

trait PaymentProviderRelationshipTrait
{
    /**
     * Get all users registered to the specified payment provider
     *
     * @return mixed
     */
    public function userPaymentCustomer()
    {
        return $this->hasMany(UserPaymentCustomer::class);
    }
}
