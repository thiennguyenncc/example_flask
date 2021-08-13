<?php

namespace Bachelor\Domain\PaymentManagement\Invoice\Interfaces;

interface ExtChargeRepositoryInterface
{
    /**
     * Retrieve customer charges
     *
     * @param array $payload
     * @return ExtChargeRepositoryInterface
     */
    public function retrieveStripeCustomerCharges(array $payload): ExtChargeRepositoryInterface;

    /**
     * Create New Charge
     *
     * @param array $payload
     * @return ExtChargeRepositoryInterface
     */
    public function createNewCharge(string $customerId, array $payload): ExtChargeRepositoryInterface;

    /**
     * Format response for stripe customer charges
     *
     * @return array
     */
    public function formatDataRetrievingCustomerCharges(): array;
}
