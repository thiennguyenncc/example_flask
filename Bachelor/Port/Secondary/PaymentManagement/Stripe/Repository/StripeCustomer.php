<?php

namespace Bachelor\Port\Secondary\PaymentManagement\Stripe\Repository;

use Bachelor\Domain\PaymentManagement\PaymentCard\Models\PaymentCard;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Interfaces\ExtPaymentCustomerRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Models\UserPaymentCustomer;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Port\Secondary\PaymentManagement\Stripe\Base\StripeBaseRepository;
use Exception;
use Stripe\Customer;

class StripeCustomer extends StripeBaseRepository implements ExtPaymentCustomerRepositoryInterface
{
    /**
     * create Stripe Customer
     *
     * @param User $user
     * @param string|null $sourceToken
     * @return string
     */
    public function createCustomer(User $user, ?string $sourceToken = null): string
    {
        $payload = [
            "email" => $user->getEmail(),
            "phone" => $user->getMobileNumber(),
            "metadata" => [
                "user_id" => $user->getId()
            ]
        ];

        if ($sourceToken) {
            $payload["source"] = $sourceToken;
        }

        return \Stripe\Customer::create($payload)->id;
    }

    /**
     * create Stripe Customer
     *
     * @param User $user
     * @return object
     */
    public function updateCustomer(User $user): bool
    {
        if (!$user->getUserPaymentCustomer()) return false;

        $payload = [
            "email" => $user->getEmail(),
            "phone" => $user->getMobileNumber(),
            "metadata" => [
                "user_id" => $user->getId()
            ]
        ];

        return (bool) \Stripe\Customer::update($user->getUserPaymentCustomer()->getThirdPartyCustomerId(), $payload);
    }

    /**
     * Create customer sources
     *
     * @param array $payload
     * @return string
     * @throws Exception
     */
    public function storeCustomerSource(UserPaymentCustomer $userPaymentCustomer, string $sourceToken): string
    {
        $sources = ['source' => $sourceToken];
        return \Stripe\Customer::createSource($userPaymentCustomer->getThirdPartyCustomerId(), $sources)->id;
    }

    /**
     * Update default source in stripe
     *
     * @param UserPaymentCustomer $userPaymentCustomer
     * @param PaymentCard $paymentCard
     * @return object
     * @throws Exception
     */
    public function updateDefaultSource(UserPaymentCustomer $userPaymentCustomer, PaymentCard $paymentCard): Customer
    {
        $source = ['default_source' => $paymentCard->getThirdPartyCardId()];
        return \Stripe\Customer::update($userPaymentCustomer->getThirdPartyCustomerId(), $source);
    }

    /**
     * retrieve default source info in stripe
     *
     * @param UserPaymentCustomer $userPaymentCustomer
     * @return array
     *```
     * [
     *      "id" => "card_1J82jPGW9rUcsW6A3U2p4Qgu",
     *      "last4" => "4314"
     * ]
     * ```
     * @throws Exception
     */
    public function retrieveDefaultSourceInfo(UserPaymentCustomer $userPaymentCustomer): array
    {
        $defaultSourceId = Customer::retrieve($userPaymentCustomer->getThirdPartyCustomerId())->default_source;
        $defaultSource = Customer::retrieveSource($userPaymentCustomer->getThirdPartyCustomerId(), $defaultSourceId);

        return [
            "id" => $defaultSource->id,
            "last4" => $defaultSource->last4,
        ];
    }

    /**
     * delete Stripe Customer Source
     *
     * @param UserPaymentCustomer $userPaymentCustomer
     * @param PaymentCard $paymentCard
     * @return Customer
     */
    public function deleteCustomerSource(UserPaymentCustomer $userPaymentCustomer, PaymentCard $paymentCard): object
    {
        return \Stripe\Customer::deleteSource($userPaymentCustomer->getThirdPartyCustomerId(), $paymentCard->getThirdPartyCardId());
    }
}
