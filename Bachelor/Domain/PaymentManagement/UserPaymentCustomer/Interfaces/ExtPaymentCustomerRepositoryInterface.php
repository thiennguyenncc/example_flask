<?php

namespace Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Interfaces;

use Bachelor\Domain\PaymentManagement\PaymentCard\Models\PaymentCard;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Models\UserPaymentCustomer;
use Bachelor\Domain\UserManagement\User\Models\User;
use Stripe\Exception\ApiErrorException;

interface ExtPaymentCustomerRepositoryInterface
{
    /**
     * create Stripe Customer
     *
     * @param User $user
     * @param string|null $sourceToken
     * @return string
     */
    public function createCustomer(User $user, ?string $sourceToken = null): string;

    /**
     * store Customer Source
     *
     * @param UserPaymentCustomer $userPaymentCustomer
     * @param string $sourceToken
     * @return string
     */
    public function storeCustomerSource(UserPaymentCustomer $userPaymentCustomer, string $sourceToken): string;

    /**
     * Update default source in stripe
     *
     * @param string $sourceId
     * @return object
     */
    public function updateDefaultSource(UserPaymentCustomer $userPaymentCustomer, PaymentCard $paymentCard): object;

    /**
     * retrieve default source in stripe
     *
     * @param UserPaymentCustomer $userPaymentCustomer
     * @return array
     * ```
     * [
     *      "id" => "card_1J82jPGW9rUcsW6A3U2p4Qgu",
     *      "last4" => "4314"
     * ]
     * ```
     * @throws Exception
     */
    public function retrieveDefaultSourceInfo(UserPaymentCustomer $userPaymentCustomer): array;

    /**
     * delete Stripe Customer Source
     *
     * @param UserPaymentCustomer $userPaymentCustomer
     * @param PaymentCard $paymentCard
     * @return Customer
     */
    public function deleteCustomerSource(UserPaymentCustomer $userPaymentCustomer, PaymentCard $paymentCard): object;
}
