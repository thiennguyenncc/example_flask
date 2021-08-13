<?php

namespace Bachelor\Domain\DatingManagement\DatingDay\Models;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\DatingManagement\DatingDay\Enums\DatingDayOfWeek;
use Carbon\Carbon;

class DatingDay extends BaseDomainModel
{
    private string $datingDayOfWeek;

    private string $datingDate;

    public function __construct(string $datingDayOfWeek, string $datingDate)
    {
        $this->setDatingDayOfWeek($datingDayOfWeek);
        $this->setDatingDate($datingDate);
    }

    /**
     * @return string
     */
    public function getDatingDayOfWeek(): string
    {
        return $this->datingDayOfWeek;
    }

    /**
     * @param string $datingDayOfWeek
     */
    public function setDatingDayOfWeek(string $datingDayOfWeek): void
    {
        $this->datingDayOfWeek = $datingDayOfWeek;
    }

    /**
     * @return string
     */
    public function getDatingDate(): string
    {
        return $this->datingDate;
    }

    /**
     * @param string $datingDate
     */
    public function setDatingDate(string $datingDate): void
    {
        $this->datingDate = $datingDate;
    }

    /**
     * @return Carbon
     */
    public function getMainMatchingTime(): Carbon
    {
        return Carbon::parse($this->datingDate)->subDay()->addHours(5);
    }

    /**
     * @return Carbon
     */
    public function getRematchingTime(): Carbon
    {
        return Carbon::createFromFormat('Y-m-d H:i:s',  $this->datingDate." ".config('matching.rematching_time'));
    }

    /**
     * @return string
     */
    public function getDatingDateJaFormat(): string
    {
        return Carbon::parse($this->getDatingDate())->format('m月d日');
    }

    /**
     * @return string
     */
    public function getDatingDateJaFeedbackFormat(): string
    {
        return Carbon::parse($this->getDatingDate())->format('m/d');
    }

    /**
     * @return string
     * 月|火|水|木|金|土|日
     */
    public function getDatingDayOfWeekJa(): string
    {
        return Carbon::parse($this->getDatingDate())->isoFormat('ddd');
    }

    /**
     * @return Carbon
     */
    public function getDeadlineFBCalcForReport(): Carbon
    {
        $startOfdatingDate = Carbon::parse($this->getDatingDate())->startOfDay();

        return $startOfdatingDate->addDays(3)->hour(21);
    }

    /**
     * @return Carbon
     */
    public function getDatingReportWillDisplayDate(): Carbon
    {
        $datingDayOfWeek = $this->getDatingDayOfWeek();
        $datingDate = Carbon::parse($this->getDatingDate());

        if ($datingDayOfWeek == DatingDayOfWeek::Wednesday) {
            $timeDisplayDatingReport = $datingDate->startOfWeek()->addDays(6);
        } elseif ($datingDayOfWeek == DatingDayOfWeek::Saturday || $datingDayOfWeek == DatingDayOfWeek::Sunday) {
            $timeDisplayDatingReport = $datingDate->endOfWeek()->addDays(4)->startOfDay();
        } else {
            throw new \Exception('Dating day of week is invalid');
        }

        return $timeDisplayDatingReport;
    }

    /**
     * @return integer
     */
    public function getTimeRemaining(): int
    {
        return Carbon::now()->diffInSeconds(Carbon::parse($this->getDatingDate())->subDays(1), false);
    }

    /**
     * @return Carbon
     */
    public function getChatOpenTime(): Carbon
    {
        $datingDate = Carbon::parse($this->datingDate)->startOfDay();
        return Carbon::parse($datingDate)->subDay()->addHours(15);
    }

    /**
     * @return Carbon
     */
    public function getChatCloseTime(): Carbon
    {
        $datingDate = Carbon::parse($this->datingDate)->startOfDay();
        return Carbon::parse($datingDate)->addHours(21);
    }

    /**
     * @return boolean
     */
    public function isChatAble(): bool
    {
        $now = Carbon::now();
        if ($now > $this->getChatOpenTime() && $now < $this->getChatCloseTime()) {
            return true;
        }
        return false;
    }

}
