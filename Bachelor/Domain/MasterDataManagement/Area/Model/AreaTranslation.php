<?php

namespace Bachelor\Domain\MasterDataManagement\Area\Model;

use Bachelor\Domain\Base\BaseDomainModel;

class AreaTranslation extends BaseDomainModel
{
    private int $areaId;
    private int $languageId;
    private string $name;

    /**
     * Area constructor.
     * @param int $areaId
     * @param int $languageId
     * @param string $name
     */
    public function __construct (
        int $areaId,
        int $languageId,
        string $name
    )
    {
        $this->setAreaId($areaId);
        $this->setLanguageId($languageId);
        $this->setName($name);
    }

    /**
     * @return int
     */
    public function getAreaId(): int
    {
        return $this->areaId;
    }

    /**
     * @param int $areaId
     */
    public function setAreaId(int $areaId): void
    {
        $this->areaId = $areaId;
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

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }



}
