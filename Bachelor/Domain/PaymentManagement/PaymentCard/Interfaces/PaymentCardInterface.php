<?php

namespace Bachelor\Domain\PaymentManagement\PaymentCard\Interfaces;

use Bachelor\Domain\PaymentManagement\PaymentCard\Models\PaymentCard;
use Bachelor\Domain\UserManagement\User\Models\User;
use Illuminate\Support\Collection;

interface PaymentCardInterface
{
    /**
     * @param $value
     * @param string $column
     * @return PaymentCard
     */
    public function getSpecificPaymentCard($value, string $column = 'third_party_card_id'): PaymentCard;

    /**
     * @param User $user
     * @return Collection
     */
    public function getPaymentCardCollectionByUser(User $user): Collection;

    /**
     * @param User $user
     * @param int $id
     * @return PaymentCard
     */
    public function getPaymentCardById(int $id): ?PaymentCard;

    /**
     * @param string $thirdPartyPaymentCardId
     * @return PaymentCard|null
     */
    public function getPaymentCardByThirdPartyCardId(string $thirdPartyPaymentCardId): ?PaymentCard;

    /**
     * @param string $thirdPartyPaymentCardId
     * @return bool
     */
    public function deletePaymentCardByThirdPartyCardId(string $thirdPartyPaymentCardId): bool;

    /**
     * Create new payment card
     *
     * @param PaymentCard $paymentCard
     * @return PaymentCard
     */
    public function save(PaymentCard $paymentCard): PaymentCard;
}
