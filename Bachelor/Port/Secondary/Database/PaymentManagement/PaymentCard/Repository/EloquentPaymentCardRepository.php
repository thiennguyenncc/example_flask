<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\PaymentCard\Repository;

use Bachelor\Domain\PaymentManagement\PaymentCard\Interfaces\PaymentCardInterface;
use Bachelor\Domain\PaymentManagement\PaymentCard\Models\PaymentCard;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\PaymentManagement\PaymentCard\ModelDao\PaymentCard as PaymentCardDao;
use Exception;
use Illuminate\Support\Collection;

class EloquentPaymentCardRepository extends EloquentBaseRepository implements PaymentCardInterface
{
    /**
     * EloquentPaymentCardRepository constructor.
     * @param PaymentCardDao $paymentCard
     */
    public function __construct(PaymentCardDao $paymentCard)
    {
        parent::__construct($paymentCard);
    }

    /**
     * @param $value
     * @param string $column
     * @return PaymentCard
     */
    public function getSpecificPaymentCard($value, string $column = 'user_id'): PaymentCard
    {
        return $this->modelDAO->getSpecificData($value, $column)->first()->toDomainEntity();
    }

    /**
     * @param User $user
     * @return Collection
     */
    public function getPaymentCardCollectionByUser(User $user): Collection
    {
        if (!$user->getUserPaymentCustomer()) return collect();

        $paymentCards = $this->createQuery()
            ->where('user_payment_customer_id', $user->getUserPaymentCustomer()->getId())
            ->get();

        return $this->transformCollection($paymentCards);
    }

    /**
     * @param User $user
     * @param int $id
     * @return PaymentCard
     */
    public function getPaymentCardById(int $id): ?PaymentCard
    {
        $paymentCard = $this->createQuery()->find($id);

        return optional($paymentCard)->toDomainEntity();
    }

    /**
     * @param string $thirdPartyPaymentCardId
     * @return PaymentCard|null
     */
    public function getPaymentCardByThirdPartyCardId(string $thirdPartyPaymentCardId): ?PaymentCard
    {
        $paymentCard = $this->createQuery()->where("third_party_card_id", $thirdPartyPaymentCardId)->first();

        return optional($paymentCard)->toDomainEntity();
    }

    /**
     * @param string $thirdPartyPaymentCardId
     * @return bool
     */
    public function deletePaymentCardByThirdPartyCardId(string $thirdPartyPaymentCardId): bool
    {
        $paymentCard = $this->createQuery()->where("third_party_card_id", $thirdPartyPaymentCardId)->first();

        return !!optional($paymentCard)->delete();
    }

    /**
     * Create new payment card
     *
     * @param PaymentCard $paymentCard
     * @return PaymentCard
     */
    public function save(PaymentCard $paymentCard): PaymentCard
    {
        return $this->createModelDAO($paymentCard->getId())->saveData($paymentCard);
    }
}
