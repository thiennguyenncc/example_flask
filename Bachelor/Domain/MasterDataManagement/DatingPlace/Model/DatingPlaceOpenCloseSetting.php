<?php

namespace Bachelor\Domain\MasterDataManagement\DatingPlace\Model;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\DatingManagement\DatingDay\Enums\DatingDayOfWeek;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class DatingPlaceOpenCloseSetting extends BaseDomainModel
{
    protected ?int $datingPlaceId;

    protected string $dayOfWeek;

    protected string $openAt;

    protected string $closeAt;

    /**
     * DatingPlaceTranslation constructor.
     * @param int|null $datingPlaceId
     * @param string $dayOfWeek
     * @param string|null $openAt
     * @param string|null $closeAt
     */
    public function __construct(
        ?int $datingPlaceId,
        string $dayOfWeek,
        string $openAt,
        string $closeAt
    ) {
        $this->setDatingPlaceId($datingPlaceId);
        $this->setDayOfWeek($dayOfWeek);
        $this->setOpenAt($openAt);
        $this->setCloseAt($closeAt);
    }

    /**
     * @return int|null
     */
    public function getDatingPlaceId(): ?int
    {
        return $this->datingPlaceId;
    }

    /**
     * @param int|null $datingPlaceId
     */
    public function setDatingPlaceId(?int $datingPlaceId): void
    {
        $this->datingPlaceId = $datingPlaceId;
    }

    /**
     * @return string
     */
    public function getDayOfWeek(): string
    {
        return $this->dayOfWeek;
    }

    /**
     * @param string $name
     */
    public function setDayOfWeek(string $dayOfWeek): void
    {
        $validator = validator([
            'dayOfWeek' => $dayOfWeek
        ], [
            'dayOfWeek' => Rule::in(DatingDayOfWeek::getValues())
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        $this->dayOfWeek = $dayOfWeek;
    }

    /**
     * @return string|null
     */
    public function getOpenAt(): ?string
    {
        return $this->openAt;
    }

    /**
     * @param string|null $openAt
     */
    public function setOpenAt(?string $openAt): void
    {
        $validator = validator([
            'openAt' => $openAt
        ], [
            'openAt' => 'date_format:H:i'
        ]);
        if ($validator->fails()) throw new ValidationException($validator);

        $this->openAt = $openAt;
    }

    /**
     * @return string|null
     */
    public function getCloseAt(): ?string
    {
        return $this->closeAt;
    }

    /**
     * @param string|null $closeAt
     */
    public function setCloseAt(?string $closeAt): void
    {
        $validator = validator([
            'closeAt' => $closeAt
        ], [
            'closeAt' => 'date_format:H:i'
        ]);
        if ($validator->fails()) throw new ValidationException($validator);

        $this->closeAt = $closeAt;
    }
}
