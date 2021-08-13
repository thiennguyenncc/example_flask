<?php

namespace Bachelor\Domain\PaymentManagement\UserPlan\Models;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\PaymentManagement\Plan\Models\Plan;
use Bachelor\Domain\PaymentManagement\UserPlan\Enum\UserPlanStatus;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserPlan extends BaseDomainModel
{
    /*
     * @var int
     */
    private int $userId;

    /*
     * @var Plan
     */
    private Plan $plan;

    /**
     * @var int
     */
    private int $status;

    /*
     * @var datetime
     */
    private ?Carbon $activateAt;

    /**
     * UserPlan constructor.
     * @param int $userId
     * @param Plan $plan
     * @param $activateAt
     */
    public function __construct(int $userId, Plan $plan, int $status = UserPlanStatus::Active, ?Carbon $activateAt = null)
    {
        $this->setUserId($userId);
        $this->setPlan($plan);
        $this->setStatus($status);
        $this->setActivateAt($activateAt);
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
     * @return Plan
     */
    public function getPlan(): Plan
    {
        return $this->plan;
    }

    /**
     * @param Plan $plan
     */
    public function setPlan(Plan $plan): void
    {
        $this->plan = $plan;
    }

    /**
     * @return mixed
     */
    public function getActivateAt()
    {
        return $this->activateAt;
    }

    /**
     * @param mixed $activateAt
     */
    public function setActivateAt($activateAt): void
    {
        $this->activateAt = $activateAt;
    }

    /**
     * Get the value of status
     *
     * @return  int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param  int  $status
     */
    public function setStatus(int $status)
    {
        $validator = validator([
            'status' => $status
        ], [
            'status' => [
                Rule::in(UserPlanStatus::getValues())
            ]
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $this->status = $status;
    }

    public function cancel(): void
    {
        if ($this->status === UserPlanStatus::Scheduled) {
            $this->setStatus(UserPlanStatus::ScheduleCanceled);
        }
    }
}
