<?php

namespace Bachelor\Domain\MasterDataManagement\ReviewPoint\Models;

use Bachelor\Domain\Base\BaseDomainModel;

class ReviewPoint extends BaseDomainModel
{
    /**
     * @var string
     */
    protected string $label;

    /**
     * @var string
     */
    protected string $key;

    /**
     * @var int
     */
    protected int $status;

    /**
     * ReviewPoint constructor.
     * @param string $label
     * @param int $key
     * @param int $status
     */
    public function __construct(string $label, int $key, int $status)
    {
        $this->setLabel($label);
        $this->setKey($key);
        $this->setStatus($status);
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
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

}
