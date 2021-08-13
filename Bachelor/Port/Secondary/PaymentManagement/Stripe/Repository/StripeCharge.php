<?php

namespace Bachelor\Port\Secondary\PaymentManagement\Stripe\Repository;

use Bachelor\Domain\PaymentManagement\Invoice\Interfaces\ExtChargeRepositoryInterface;
use Bachelor\Port\Secondary\PaymentManagement\Stripe\Base\StripeBaseRepository;
use Stripe\Exception\ApiErrorException;

class StripeCharge extends StripeBaseRepository implements ExtChargeRepositoryInterface
{
    /*
     * Stripe Charges
     */
    private $charges;

    /**
     * Retrieve customer charges
     *
     * @param array $payload
     * @return ExtChargeRepositoryInterface
     * @throws ApiErrorException
     */
    public function retrieveStripeCustomerCharges(array $payload): ExtChargeRepositoryInterface
    {
        $this->charges = \Stripe\Charge::all($payload);

        return $this;
    }

    /**
     * Create New Charges
     *
     * @param array $payload
     * @return ExtChargeRepositoryInterface
     * @throws ApiErrorException
     */
    public function createNewCharge(string $customerId, array $payload): ExtChargeRepositoryInterface
    {
        $this->charges = \Stripe\Charge::create(array_merge(['customer' => $customerId], $payload));

        return $this;
    }

    /**
     * Format response for stripe customer charges
     *
     * @return array
     */
    public function formatDataRetrievingCustomerCharges(): array
    {
        return [
            'charges' => $this->charges['data'] ?? ''
        ];
    }
}
