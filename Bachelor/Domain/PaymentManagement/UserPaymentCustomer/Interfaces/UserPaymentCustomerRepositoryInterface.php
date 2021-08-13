<?php

namespace Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Interfaces;

use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Models\UserPaymentCustomer;

interface UserPaymentCustomerRepositoryInterface
{
    /**
     *
     * @param string $customerId
     * @return UserPaymentCustomer|null
     */
    public function getUserPaymentCustomerByThirdPartyId(string $customerId) : ?UserPaymentCustomer;

    /**
     *
     * @param int $user_id
     * @return UserPaymentCustomer|null
     */
    public function getUserPaymentCustomerByUserId(int $user_id): ?UserPaymentCustomer;

    /**
     * Create new user payment customer
     *
     * @param UserPaymentCustomer $paymentCard
     * @return UserPaymentCustomer
     */
    public function save ( UserPaymentCustomer $paymentCard ): UserPaymentCustomer;
}
