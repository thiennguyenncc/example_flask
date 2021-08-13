<?php

namespace Bachelor\Domain\PaymentManagement\Subscription\Models;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\PaymentManagement\Subscription\Enum\SubscriptionStatus;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Models\UserPaymentCustomer;
use Bachelor\Domain\PaymentManagement\UserPlan\Models\UserPlan;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class Subscription extends BaseDomainModel
{
    private UserPaymentCustomer $userPaymentCustomer;

    private string $thirdPartySubscriptionId;

    /*
     * @var datetime
     */
    private Carbon $startsAt;

    /*
     * @var datetime
     */
    private Carbon $endsAt;

    /**
     * @var Carbon|null
     */
    private ?Carbon $nextStartsAt;

    /*
     * @var datetime
     */
    private ?Carbon $cancelledAt;

    /*
     * @var string
     */
    private string $status;

    /**
     * Subscription constructor.
     * @param UserPaymentCustomer $userPaymentCustomer
     * @param $startsAt
     * @param $endsAt
     * @param $cancelledAt
     * @param string $status
     */
    public function __construct(
        UserPaymentCustomer $userPaymentCustomer,
        string $thirdPartySubscriptionId,
        Carbon $startsAt,
        Carbon $nextStartsAt,
        ?Carbon $cancelledAt = null,
        string $status = SubscriptionStatus::Active
    ) {
        $this->setUserPaymentCustomer($userPaymentCustomer);
        $this->setThirdPartySubscriptionId($thirdPartySubscriptionId);
        $this->setStartsAt($startsAt);
        $this->setNextStartsAt($nextStartsAt);
        $this->setCancelledAt($cancelledAt);
        $this->setStatus($status);
    }

    public function cancel(): void
    {
        $this->setStatus(SubscriptionStatus::Canceled);
        $this->setCancelledAt(Carbon::now());
    }

    /**
     * @return string
     */
    public function getThirdPartySubscriptionId(): string
    {
        return $this->thirdPartySubscriptionId;
    }

    /**
     * @param string $thirdPartySubscriptionId
     */
    public function setThirdPartySubscriptionId(string $thirdPartySubscriptionId): void
    {
        $this->thirdPartySubscriptionId = $thirdPartySubscriptionId;
    }

    /**
     * @return mixed
     */
    public function getStartsAt(): Carbon
    {
        return $this->startsAt;
    }

    /**
     * @param mixed $startsAt
     */
    public function setStartsAt(Carbon $startsAt): void
    {
        $this->startsAt = $startsAt;
    }

    /**
     * @return Carbon|null
     */
    public function getNextStartsAt(): ?Carbon
    {
        return $this->nextStartsAt;
    }

    /**
     * @param Carbon|null $nextStartsAt
     */
    public function setNextStartsAt(?Carbon $nextStartsAt): void
    {
        $this->nextStartsAt = $nextStartsAt;
    }

    /**
     * @return mixed
     */
    public function getCancelledAt(): ?Carbon
    {
        return $this->cancelledAt;
    }

    /**
     * @param mixed $cancelledAt
     */
    public function setCancelledAt(?Carbon $cancelledAt): void
    {
        $this->cancelledAt = $cancelledAt;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $validator = validator(
            ['status' => $status],
            ['status' => [Rule::in(SubscriptionStatus::getValues())]]
        );
        if ($validator->fails()) throw new ValidationException($validator);

        $this->status = $status;
    }

    public function getUserPaymentCustomer(): UserPaymentCustomer
    {
        return $this->userPaymentCustomer;
    }

    public function setUserPaymentCustomer(UserPaymentCustomer $userPaymentCustomer): void
    {
        $this->userPaymentCustomer = $userPaymentCustomer;
    }

    /**
     * @return string
     */
    public function getJaNextStartsAt(): string
    {
        return $this->getNextStartsAt()->isoFormat('MM月DD日(ddd)');
    }

    /**
     * @return string
     */
    public function getJaStartsAt(): string
    {
        return $this->getStartsAt()->isoFormat('MM月DD日(ddd)');
    }

    /**
     * @return string
     */
    public function getJaEndsAt(): string
    {
        return $this->getEndsAt()->isoFormat('MM月DD日(ddd)');
    }

    /**
     * @return Carbon
     */
    public function getEndsAt(): Carbon
    {
        return $this->getNextStartsAt()->copy()->subDay()->endOfDay();
    }
}
