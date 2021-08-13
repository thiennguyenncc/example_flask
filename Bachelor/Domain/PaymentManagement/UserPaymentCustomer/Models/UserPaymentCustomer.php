<?php

namespace Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Models;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\PaymentManagement\PaymentCard\Models\PaymentCard;
use Bachelor\Domain\PaymentManagement\PaymentProvider\Models\PaymentProvider;
use Illuminate\Database\Eloquent\Collection;

class UserPaymentCustomer extends BaseDomainModel
{
    /**
     * @var int
     */
    private int $userId;

    /**
     * @var string
     */
    private string $thirdPartyCustomerId;

    /**
     * @var PaymentProvider
     */
    private PaymentProvider $paymentProvider;

    /**
     * @var PaymentCard|null
     */
    private ?PaymentCard $defaultPaymentCard = null;

    /**
     * UserPaymentCustomer constructor.
     * @param int $userId
     * @param string $thirdPartyCustomerId
     * @param PaymentProvider $paymentProvider
     * @param PaymentCard|null $defaultPaymentCard
     */
    public function __construct(
        int $userId,
        string $thirdPartyCustomerId,
        PaymentProvider $paymentProvider,
        ?PaymentCard $defaultPaymentCard = null
    ) {
        $this->setUserId($userId);
        $this->setThirdPartyCustomerId($thirdPartyCustomerId);
        $this->setPaymentProvider($paymentProvider);
        $this->setDefaultPaymentCard($defaultPaymentCard);
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getThirdPartyCustomerId(): string
    {
        return $this->thirdPartyCustomerId;
    }

    /**
     * @param string $thirdPartyCustomerId
     */
    public function setThirdPartyCustomerId(string $thirdPartyCustomerId): void
    {
        $this->thirdPartyCustomerId = $thirdPartyCustomerId;
    }


    /**
     * @return PaymentProvider
     */
    public function getPaymentProvider(): PaymentProvider
    {
        return $this->paymentProvider;
    }

    /**
     * @param PaymentProvider $paymentProvider
     */
    public function setPaymentProvider(PaymentProvider $paymentProvider): void
    {
        $this->paymentProvider = $paymentProvider;
    }

    /**
     * Get the value of defaultPaymentCard
     * @return  PaymentCard|null
     */
    public function getDefaultPaymentCard(): ?PaymentCard
    {
        return $this->defaultPaymentCard;
    }

    /**
     * Set the value of defaultPaymentCard
     *@param PaymentCard|null $defaultPaymentCard
     */
    public function setDefaultPaymentCard(?PaymentCard $defaultPaymentCard): void
    {
        $this->defaultPaymentCard = $defaultPaymentCard;
    }
}
