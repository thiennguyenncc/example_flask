<?php

namespace Bachelor\Domain\MasterDataManagement\RegisterOption\Model;

use Bachelor\Domain\Base\BaseDomainModel;

class RegisterOption extends BaseDomainModel
{

    private string $optionKey;
    private string $optionValue;
    private int $sort;
    private int $status;
    private ?int $allowedGender;
    private string $type;

    /*
     * @var string
     */
    private RegisterOptionTranslation $registerOptionTranslation;

    /**
     * RegisterOption constructor.
     *
     * @param string $optionKey
     * @param string $optionValue
     * @param int $sort
     * @param int $status
     * @param int|null $allowedGender
     * @param RegisterOptionTranslation|null $registerOptionTranslation
     */
    public function __construct(
        string $optionKey,
        string $optionValue,
        string $type,
        ?int $allowedGender,
        int $sort,
        int $status,
        ?RegisterOptionTranslation $registerOptionTranslation
    ) {
        $this->setOptionKey($optionKey);
        $this->setOptionValue($optionValue);
        $this->setSort($sort);
        $this->setStatus($status);
        $this->setType($type);
        $this->setAllowedGender($allowedGender);
        $this->setAllowedGender($allowedGender);
        $this->setRegisterOptionTranslation($registerOptionTranslation);
    }

    /**
     * @return string
     */
    public function getOptionKey(): string
    {
        return $this->optionKey;
    }

    /**
     * @param string $optionKey
     */
    public function setOptionKey(string $optionKey): void
    {
        $this->optionKey = $optionKey;
    }

    /**
     * @return string
     */
    public function getOptionValue(): string
    {
        return $this->optionValue;
    }

    /**
     * @param string $optionValue
     */
    public function setOptionValue(string $optionValue): void
    {
        $this->optionValue = $optionValue;
    }

    /**
     * @return int
     */
    public function getSort(): int
    {
        return $this->sort;
    }

    /**
     * @param int $sort
     */
    public function setSort(int $sort): void
    {
        $this->sort = $sort;
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
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return ?int
     */
    public function getAllowedGender(): ?int
    {
        return $this->allowedGender;
    }

    /**
     * @param ?int $allowedGender
     */
    public function setAllowedGender(?int $allowedGender): void
    {
        $this->allowedGender = $allowedGender;
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
     * @return RegisterOptionTranslation
     */
    public function getRegisterOptionTranslation(): RegisterOptionTranslation
    {
        return $this->registerOptionTranslation;
    }

    /**
     * @param RegisterOptionTranslation $registerOptionTranslation
     */
    public function setRegisterOptionTranslation(RegisterOptionTranslation $registerOptionTranslation): void
    {
        $this->registerOptionTranslation = $registerOptionTranslation;
    }
}
