<?php

namespace Bachelor\Domain\MasterDataManagement\StarCategory\Models;

use Bachelor\Domain\Base\BaseDomainModel;

class StarCategory extends BaseDomainModel
{
    protected string $label;

    protected int $status;

    public function __construct(string $label, int $status)
    {
        $this->setLabel($label);
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
