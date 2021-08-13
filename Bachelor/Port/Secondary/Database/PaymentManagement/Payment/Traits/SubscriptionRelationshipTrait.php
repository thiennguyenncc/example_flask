<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\Payment\Traits;

use Bachelor\Domain\PaymentManagement\UserPlan\Enum\UserPlanStatus;
use Bachelor\Port\Secondary\Database\PaymentManagement\UserPaymentCustomer\ModelDao\UserPaymentCustomer;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;

trait SubscriptionRelationshipTrait
{
    /**
     * Get the user to which this subscription belongs to
     *
     * @return mixed
     */
    public function userPaymentCustomer()
    {
        return $this->belongsTo(UserPaymentCustomer::class);
    }
}
