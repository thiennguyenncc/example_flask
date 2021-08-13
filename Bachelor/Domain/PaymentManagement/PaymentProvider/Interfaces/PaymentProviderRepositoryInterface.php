<?php

namespace Bachelor\Domain\PaymentManagement\PaymentProvider\Interfaces;

use Bachelor\Domain\PaymentManagement\PaymentProvider\Models\PaymentProvider;

interface PaymentProviderRepositoryInterface
{
    /**
     * @param $value
     * @param string $column
     * @return PaymentProvider
     */
    public function getSpecificPaymentProvider($value, string $column = 'name') : PaymentProvider;

    /**
     * @param string $value
     * @return PaymentProvider
     */
    public function getPaymentProviderByName(string $value) : PaymentProvider;

    /**
     * Create new Payment Card
     *
     * @param PaymentProvider $paymentProvider
     * @return PaymentProvider
     */
    public function save ( PaymentProvider $paymentProvider ): PaymentProvider;
}
