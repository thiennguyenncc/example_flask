<?php

namespace Bachelor\Domain\MasterDataManagement\Prefecture\Model;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Utility\Enums\Status;
use Illuminate\Database\Eloquent\Collection;

class PrefectureTranslation extends BaseDomainModel
{
    /*
     * @var int
     */
    private int $prefectureId;

    /*
     * @var int
     */
    private int $languageId;

    /*
     * @var string
     */
    private string $name;

    /**
     * Prefecture constructor.
     *
     * @param string $name
     * @param int $prefectureId
     * @param int $languageId
     */
    public function __construct (string $name, int $prefectureId, int $languageId)
    {
        $this->setName($name);
        $this->setPrefectureId($prefectureId);
        $this->setLanguageId($languageId);
    }


    /**
     * @return string
     */
    public function getName (): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName ( string $name ): void
    {
        $this->name = $name;
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
    public function getLanguageId(): int
    {
        return $this->languageId;
    }

    /**
     * @param int $languageId
     */
    public function setLanguageId(int $languageId): void
    {
        $this->languageId = $languageId;
    }


}
