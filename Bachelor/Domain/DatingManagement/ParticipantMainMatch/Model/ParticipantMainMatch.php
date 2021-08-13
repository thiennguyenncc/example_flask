<?php

namespace Bachelor\Domain\DatingManagement\ParticipantMainMatch\Model;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantsStatus;
use Bachelor\Domain\UserManagement\User\Models\User;
use Carbon\Carbon;

class ParticipantMainMatch extends BaseDomainModel
{
    private int $userId;

    private int $datingDayId;

    private int $status;

    private bool $showSampleDate = false;

    private ?User $user = null;

    private ?DatingDay $datingDay = null;

    public function __construct(int $userId, int $datingDayId, int $status = ParticipantsStatus::Awaiting, bool $showSampleDate = false)
    {
        $this->setUserId($userId);
        $this->setDatingDayId($datingDayId);
        $this->setStatus($status);
        $this->setShowSampleDate($showSampleDate);
    }

    /**
     * @return int
     */
    public function cancel(): ?self
    {
        if ($this->getStatus() !== ParticipantsStatus::Awaiting) {
            return null;
        }

        $this->setStatus(ParticipantsStatus::Cancelled);
        return $this;
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
     * @return ParticipantMainMatch
     */
    public function setUserId(int $userId): ParticipantMainMatch
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return int
     */
    public function getDatingDayId(): int
    {
        return $this->datingDayId;
    }

    /**
     * @param int $datingDayId
     * @return ParticipantMainMatch
     */
    public function setDatingDayId(int $datingDayId): ParticipantMainMatch
    {
        $this->datingDayId = $datingDayId;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return ParticipantMainMatch
     */
    public function setStatus(int $status): ParticipantMainMatch
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return bool
     */
    public function isShowSampleDate(): bool
    {
        return $this->showSampleDate;
    }

    /**
     * @param bool $showSampleDate
     * @return ParticipantMainMatch
     */
    public function setShowSampleDate(bool $showSampleDate): ParticipantMainMatch
    {
        $this->showSampleDate = $showSampleDate;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return ParticipantMainMatch
     */
    public function setUser(?User $user): ParticipantMainMatch
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return DatingDay|null
     */
    public function getDatingDay(): ?DatingDay
    {
        return $this->datingDay;
    }

    /**
     * @param DatingDay|null $datingDay
     * @return ParticipantMainMatch
     */
    public function setDatingDay(?DatingDay $datingDay): ParticipantMainMatch
    {
        $this->datingDay = $datingDay;
        return $this;
    }

    /**
     * @return Carbon
     */
    public function getParticipateDeadline(): Carbon
    {
        $participatedDatingDate = Carbon::parse($this->getDatingDay()?->getDatingDate());
        $firstRegistrationDate = $this->getUser()?->getUserInfoUpdatedTime()?->getFirstRegistrationCompletedAt();
        // diffInDays returns difference per24h. If we think 1 day diff for day diff with less 24h, we need to deduct 1 day.
        $diff = $firstRegistrationDate?->diffInDays($participatedDatingDate) - 1;
        return $diff > 7 ? $firstRegistrationDate->copy()->addWeek()->addDay()->startOfDay() : $this->getDatingDay()?->getMainMatchingTime()->startOfDay();
    }
}
