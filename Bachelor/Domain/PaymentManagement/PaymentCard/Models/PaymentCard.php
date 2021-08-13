<?php

namespace Bachelor\Domain\PaymentManagement\PaymentCard\Models;

use Bachelor\Domain\Base\BaseDomainModel;

class PaymentCard extends BaseDomainModel
{
    /*
     * TODO Not decided in the domain design need to confirm it from yoshi but its needed
     *
     * @var string
     */
    private string $thirdPartyCardId;

    /**
     * @var int
     */
    private int $userPaymentCustomerId;

    /**
     * TODO Not decided in the domain design need to confirm it from yoshi but its needed
     *
     * @var string
     */
    private string $lastFourDigits;

    /**
     * PaymentCard constructor.
     * @param int $userPaymentCustomerId
     * @param string $thirdPartyCardId
     * @param string $lastFourDigits
     */
    public function __construct(
        int $userPaymentCustomerId,
        string $thirdPartyCardId,
        string $lastFourDigits
    ) {
        $this->setUserPaymentCustomerId($userPaymentCustomerId);
        $this->setThirdPartyCardId($thirdPartyCardId);
        $this->setLastFourDigits($lastFourDigits);
    }

    /**
     * @return int
     */
    public function getUserPaymentCustomerId(): int
    {
        return $this->userPaymentCustomerId;
    }

    /**
     * @param int $userPaymentCustomerId
     */
    public function setUserPaymentCustomerId(int $userPaymentCustomerId): void
    {
        $this->userPaymentCustomerId = $userPaymentCustomerId;
    }

    /**
     * @return string
     */
    public function getThirdPartyCardId(): string
    {
        return $this->thirdPartyCardId;
    }

    /**
     * @param string $thirdPartyCardId
     */
    public function setThirdPartyCardId(string $thirdPartyCardId): void
    {
        $this->thirdPartyCardId = $thirdPartyCardId;
    }

    /**
     * @return string
     */
    public function getLastFourDigits(): string
    {
        return $this->lastFourDigits;
    }

    /**
     * @param string $lastFourDigits
     */
    public function setLastFourDigits(string $lastFourDigits): void
    {
        $this->lastFourDigits = $lastFourDigits;
    }
}
