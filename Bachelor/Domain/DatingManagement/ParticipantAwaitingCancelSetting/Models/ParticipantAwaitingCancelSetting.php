<?php

namespace Bachelor\Domain\DatingManagement\ParticipantAwaitingCancelSetting\Models;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;

class ParticipantAwaitingCancelSetting extends BaseDomainModel
{
    private int $datingDayId;
    private int $gender;
    private int $daysBefore;
    private float $ratio;

    private ?DatingDay $datingDay = null;

    public function __construct(int $datingDayId, int $gender, int $daysBefore, float $ratio)
    {
        $this->setDatingDayId($datingDayId);
        $this->setGender($gender);
        $this->setDaysBefore($daysBefore);
        $this->setRatio($ratio);
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
     */
    public function setDatingDayId(int $datingDayId): void
    {
        $this->datingDayId = $datingDayId;
    }

    /**
     * @return int
     */
    public function getGender(): int
    {
        return $this->gender;
    }

    /**
     * @param int $gender
     */
    public function setGender(int $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return int
     */
    public function getDaysBefore(): int
    {
        return $this->daysBefore;
    }

    /**
     * @param int $daysBefore
     */
    public function setDaysBefore(int $daysBefore): void
    {
        $this->daysBefore = $daysBefore;
    }

    /**
     * @return float
     */
    public function getRatio(): float
    {
        return $this->ratio;
    }

    /**
     * @param float $ratio
     */
    public function setRatio(float $ratio): void
    {
        $this->ratio = $ratio;
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
     */
    public function setDatingDay(?DatingDay $datingDay): void
    {
        $this->datingDay = $datingDay;
    }
}
