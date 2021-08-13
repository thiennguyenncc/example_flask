<?php

namespace Bachelor\Domain\DatingManagement\ParticipationOpenExpirySetting\Model;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\DatingManagement\ParticipationOpenExpirySetting\Enums\ParticipationOpenExpireStatus;
use Carbon\Carbon;

class ParticipationOpenExpirySetting extends BaseDomainModel
{
    private string $dating_day_of_week;

    private int $is_user_2nd_form_completed;

    private int $user_gender;

    private int $open_days_before_dating_date;

    private int $expiry_days_before_dating_date;

    public function __construct(string $dating_day_of_week, int $is_user_2nd_form_completed, int $user_gender, int $open_days_before_dating_date, int $expiry_days_before_dating_date)
    {
        $this->setDatingDayOfWeek($dating_day_of_week);
        $this->setIsUser2ndFormCompleted($is_user_2nd_form_completed);
        $this->setUserGender($user_gender);
        $this->setOpenDaysBeforeDatingDate($open_days_before_dating_date);
        $this->setExpiryDaysBeforeDatingDate($expiry_days_before_dating_date);
    }

    /**
     * @return string
     */
    public function getDatingDayOfWeek(): string
    {
        return $this->dating_day_of_week;
    }

    /**
     * @param string $dating_day_of_week
     */
    public function setDatingDayOfWeek(string $dating_day_of_week): void
    {
        $this->dating_day_of_week = $dating_day_of_week;
    }

    /**
     * @return int
     */
    public function getIsUser2ndFormCompleted(): int
    {
        return $this->is_user_2nd_form_completed;
    }

    /**
     * @param int $is_user_2nd_form_completed
     */
    public function setIsUser2ndFormCompleted(int $is_user_2nd_form_completed): void
    {
        $this->is_user_2nd_form_completed = $is_user_2nd_form_completed;
    }

    /**
     * @return int
     */
    public function getUserGender(): int
    {
        return $this->user_gender;
    }

    /**
     * @param int $user_gender
     */
    public function setUserGender(int $user_gender): void
    {
        $this->user_gender = $user_gender;
    }

    /**
     * @return int
     */
    public function getOpenDaysBeforeDatingDate(): int
    {
        return $this->open_days_before_dating_date;
    }

    /**
     * @param int $open_days_before_dating_date
     */
    public function setOpenDaysBeforeDatingDate(int $open_days_before_dating_date): void
    {
        $this->open_days_before_dating_date = $open_days_before_dating_date;
    }

    /**
     * @return int
     */
    public function getExpiryDaysBeforeDatingDate(): int
    {
        return $this->expiry_days_before_dating_date;
    }

    /**
     * @param int $expiry_days_before_dating_date
     */
    public function setExpiryDaysBeforeDatingDate(int $expiry_days_before_dating_date): void
    {
        $this->expiry_days_before_dating_date = $expiry_days_before_dating_date;
    }

    /**
     * @param string $datingDate
     * @return Carbon
     */
    public function getOpenDate(string $datingDate): Carbon
    {
        return Carbon::create($datingDate)->subDays($this->open_days_before_dating_date);
    }

    /**
     * @param string $datingDate
     * @return Carbon
     */
    public function getExpireDate(string $datingDate): Carbon
    {
        return Carbon::create($datingDate)->subDays($this->expiry_days_before_dating_date);
    }

    /**
     * @return int
     */
    public function getOpenExpireStatusOn(string $datingDate): int
    {
        if (Carbon::now()->toDateString() >= $this->getExpireDate($datingDate)->toDateString()) {
            return ParticipationOpenExpireStatus::Expired;
        }
        if (Carbon::now()->toDateString() >= $this->getOpenDate($datingDate)->toDateString() && Carbon::now()->toDateString() <= $this->getExpireDate($datingDate)->toDateString()) {
            return ParticipationOpenExpireStatus::Opened;
        }
        return ParticipationOpenExpireStatus::Closed;
    }
}
