<?php


namespace Bachelor\Domain\MasterDataManagement\School\Models;


use Bachelor\Domain\Base\BaseDomainModel;

class School extends BaseDomainModel
{
    private string $schoolName;
    private int $educationGroup;
    private bool $isSelectable;

    public function __construct(
        string $schoolName,
        int $educationGroup,
        bool $isSelectable = true
    ) {
        $this->setSchoolName($schoolName);
        $this->setEducationGroup($educationGroup);
        $this->setIsSelectable($isSelectable);
    }

    /**
     * @param bool $isSelectable
     */
    public function disable(): void
    {
        $this->isSelectable = false;
    }

    /**
     * @return string
     */
    public function getSchoolName(): string
    {
        return $this->schoolName;
    }

    /**
     * @param string $schoolName
     */
    public function setSchoolName(string $schoolName): void
    {
        $this->schoolName = $schoolName;
    }

    /**
     * @return int
     */
    public function getEducationGroup(): int
    {
        return $this->educationGroup;
    }

    /**
     * @param int $educationGroup
     */
    public function setEducationGroup(int $educationGroup): void
    {
        $this->educationGroup = $educationGroup;
    }

    /**
     * @return bool
     */
    public function isSelectable(): bool
    {
        return $this->isSelectable;
    }

    /**
     * @param bool $isSelectable
     */
    public function setIsSelectable(bool $isSelectable = true): void
    {
        $this->isSelectable = $isSelectable;
    }
}
