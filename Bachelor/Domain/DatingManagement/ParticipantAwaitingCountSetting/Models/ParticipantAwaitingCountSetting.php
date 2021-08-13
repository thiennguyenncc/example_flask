<?php


namespace Bachelor\Domain\DatingManagement\ParticipantAwaitingCountSetting\Models;


use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;

class ParticipantAwaitingCountSetting extends BaseDomainModel
{
    /**
     * @var int
     */
    private int $datingDayId;
    /**
     * @var int
     */
    private int $gender;
    /**
     * @var int
     */
    private int $prefectureId;

    /**
     * @var string
     */
    private string $type;

    /**
     * @var float
     */
    private float $count = 0;

    private ?DatingDay $datingDay = null;

    /**
     * ParticipantAwaitingCountSetting constructor.
     * @param int $datingDayId
     * @param int $gender
     * @param int $prefectureId
     * @param array $settings
     */
    public function __construct(int $datingDayId, int $gender, int $prefectureId, string $type, float $count)
    {
        $this->datingDayId = $datingDayId;
        $this->gender = $gender;
        $this->prefectureId = $prefectureId;
        $this->type = $type;
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getPrefectureId(): int
    {
        return $this->prefectureId;
    }

    /**
     * @param int $prefectureId
     */
    public function setPrefectureId(int $prefectureId): void
    {
        $this->prefectureId = $prefectureId;
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

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return float
     */
    public function getCount(): float
    {
        return $this->count ?? 0;
    }

    /**
     * @param float $count
     */
    public function setCount(float $count): void
    {
        $this->count = $count;
    }
}
