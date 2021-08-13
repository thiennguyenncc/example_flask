<?php

namespace Bachelor\Domain\FeedbackManagement\DatingReport\Models;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\FeedbackManagement\DatingReport\Enum\Read;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DatingReport extends BaseDomainModel
{
    /**
     * @var int
     */
    protected int $userId;

    /**
     * @var Collection
     */
    protected Collection $datingReportGenerateFeedbacks;

    /**
     * @var string
     */
    protected array $datingReportData;
    
    /**
     * @var int
     */
    private Carbon $displayDate;
    
    /**
     * @var int
     */
    protected int $read = Read::Unread;

    /**
     * DatingReport constructor.
     * @param int $userId
     * @param Collection $datingReportGenerateFeedbacks
     * @param string $datingReportData
     * @param int $read
     * @param Carbon $displayDate
     */
    public function __construct(int $userId, Collection $datingReportGenerateFeedbacks, array $datingReportData, Carbon $displayDate, int $read = Read::Unread)
    {
        $this->setUserId($userId);
        $this->setDatingReportGenerateFeedbacks($datingReportGenerateFeedbacks);
        $this->setDatingReportData($datingReportData);
        $this->setRead($read);
        $this->setDisplayDate($displayDate);
    }

    /**
     * @return Carbon
     */
    public function getDisplayDate(): Carbon
    {
        return $this->displayDate;
    }

    /**
     * @param Carbon $displayDate
     */
    public function setDisplayDate(Carbon $displayDate): void
    {
        $this->displayDate = $displayDate;
    }

    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setDatingReportGenerateFeedbacks(Collection $datingReportGenerateFeedbacks)
    {
        $this->datingReportGenerateFeedbacks = $datingReportGenerateFeedbacks;
    }

    public function getDatingReportGenerateFeedbacks(): Collection
    {
        return $this->datingReportGenerateFeedbacks;
    }

    public function setDatingReportData(array $datingReportData)
    {
        $this->datingReportData = $datingReportData;
    }

    public function getDatingReportData(): array
    {
        return $this->datingReportData;
    }

    /**
     * @return int
     */
    public function getRead(): int
    {
        return $this->read;
    }

    /**
     * @param int $read
     */
    public function setRead(int $read): void
    {
        $this->read = $read;
    }

}
