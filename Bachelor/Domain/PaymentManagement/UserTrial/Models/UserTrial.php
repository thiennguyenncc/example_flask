<?php

namespace Bachelor\Domain\PaymentManagement\UserTrial\Models;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\PaymentManagement\UserTrial\Enum\TrialStatus;
use Bachelor\Domain\PaymentManagement\UserPlan\Models\UserPlan;
use Bachelor\Utility\Enums\Status;
use Exception;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Bachelor\Domain\Base\Exception\BaseValidationException;

class UserTrial extends BaseDomainModel
{

    /*
     * @var datetime
     */
    private Carbon $trialStart;

    /*
     * @var datetime
     */
    private Carbon $trialEnd;

    /*
     * @var int
     */
    private int  $status;

    /**
     * @var int
     */
    private ?int $userId;

    /**
     * UserTrial constructor.
     * @param int $userId
     * @param $trialStart
     * @param $trialEnd
     * @param int $status
     */
    public function __construct(int $userId, Carbon $trialStart, Carbon $trialEnd, int $status = Status::Active)
    {
        $this->setUserId($userId);
        $this->setTrialStart($trialStart);
        $this->setTrialEnd($trialEnd);
        $this->setStatus($status);
    }

    /**
     * Check if the trial is active
     *
     * @return int
     */
    public function isTrialActive(): int
    {
        return $this->status === TrialStatus::Active;
    }

    /**
     * @return Carbon
     */
    public function getTrialStart(): Carbon
    {
        return $this->trialStart;
    }

    /**
     * @param mixed $trialStart
     */
    public function setTrialStart($trialStart): void
    {
        $this->trialStart = $trialStart;
    }

    /**
     * @return Carbon
     */
    public function getTrialEnd(): Carbon
    {
        return $this->trialEnd;
    }

    /**
     * @param mixed $trialEnd
     */
    public function setTrialEnd($trialEnd): void
    {
        if ($this->trialStart >= $trialEnd) {
            throw BaseValidationException::withMessages([
                'invalid_trial_end_detected' => [
                    __('api_messages.invalid_trial_end_detected')
                ]
            ]);
        }
        $this->trialEnd = $trialEnd;
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    /**
     * @param int|null $status
     */
    private function setStatus(?int $status): void
    {
        $validator = validator([
            'status' => $status
        ], [
            'status' => [
                Rule::in(TrialStatus::getValues())
            ]
        ]);
        if ($validator->fails()) {
            throw new BaseValidationException($validator);
        }
        $this->status = $status;
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
    public function getJaTrialStart(): string
    {
        return $this->getTrialStart()->isoFormat('MM月DD日(ddd)');
    }

    /**
     * @return string
     */
    public function getJaTrialEnd(): string
    {
        return $this->getTrialEnd()->isoFormat('MM月DD日(ddd)');
    }

    /**
     * @return self|null
     */
    public function tempCancel(): self
    {
        if ($this->getStatus() !== TrialStatus::Active) {
            throw BaseValidationException::withMessages([
                'current_trial_can_not_be_temp_canceled' => [
                    __('api_messages.dating.current_trial_can_not_be_temp_canceled')
                ]
            ]);
        }
        $this->setStatus(TrialStatus::TempCancelled);
        return $this;
    }

    /**
     * @return void
     */
    public function complete(): self
    {
        $this->status = TrialStatus::Completed;
        return $this;
    }

    /**
     * @return int
     */
    public function isActive(): bool
    {
        return $this->status === TrialStatus::Active;
    }
}
