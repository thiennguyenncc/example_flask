<?php

namespace Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Factories;

use Bachelor\Domain\PaymentManagement\PaymentProvider\Models\PaymentProvider;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Models\UserPaymentCustomer;
use Bachelor\Domain\UserManagement\User\Models\User;

class UserPaymentCustomerFactory
{
    /**
     * @param User $user
     * @param PaymentProvider $paymentProvider
     * @param string $thirdPartyCustomerId
     * @return UserPaymentCustomer
     */
    public function createUserPaymentCustomer(User $user, PaymentProvider $paymentProvider, string $thirdPartyCustomerId) : UserPaymentCustomer
    {
        return new UserPaymentCustomer($user->getId(), $thirdPartyCustomerId, $paymentProvider);
    }
}
