<?php

namespace Bachelor\Domain\MasterDataManagement\RegisterOption\Model;

use Bachelor\Domain\Base\BaseDomainModel;

class RegisterOptionTranslation extends BaseDomainModel
{
    /*
     * @var int
     */
    private int $registerOptionId;

    /*
     * @var int
     */
    private int $languageId;

    /*
     * @var string
     */
    private string $labelName;

    /*
     * @var string
     */
    private string $displayName;

    /**
     * RegisterOptionTranslation constructor.
     *
     * @param int $registerOptionId
     * @param int $languageId
     * @param string $labelName
     * @param string $displayName
     */
    public function __construct (
        int $registerOptionId,
        int $languageId,
        string $labelName,
        string $displayName
    ){
        $this->setRegisterOptionId($registerOptionId);
        $this->setLanguageId($languageId);
        $this->setLabelName($labelName);
        $this->setDisplayName($displayName);
    }

    /**
     * @return int
     */
    public function getRegisterOptionId(): int
    {
        return $this->registerOptionId;
    }

    /**
     * @param int $registerOptionId
     */
    public function setRegisterOptionId(int $registerOptionId): void
    {
        $this->registerOptionId = $registerOptionId;
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
    public function getLabelName(): string
    {
        return $this->labelName;
    }

    /**
     * @param string $labelName
     */
    public function setLabelName(string $labelName): void
    {
        $this->labelName = $labelName;
    }

    /**
     * @return string
     */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    /**
     * @param string $displayName
     */
    public function setDisplayName(string $displayName): void
    {
        $this->displayName = $displayName;
    }

}
