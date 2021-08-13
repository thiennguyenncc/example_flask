<?php

namespace Bachelor\Domain\MasterDataManagement\MatchInfoGroup\Models;

use Bachelor\Domain\Base\BaseDomainModel;

class MatchInfo extends BaseDomainModel
{
    /**
     * @var ?integer
     */
    private ?int $groupId;

    /**
     * @var string
     */
    private string $description;

    /**
     * @var string
     */
    private string $image;

    /**
     * Match Info constructor.
     *
     * @param ?int $groupId
     * @param string $description
     * @param string $image
     */
    public function __construct(
        ?int $groupId,
        string $description,
        string $image,
    ) {
        $this->setGroupId($groupId);
        $this->setDescription($description);
        $this->setImage($image);
    }

    /**
     * Set the value of match info group
     *
     * @param int $groupId
     * @return void
     */
    public function setGroupId(?int $groupId): void
    {
        $this->groupId = $groupId;
    }

    /**
     * Get group id value
     *
     * @return int
     */
    public function getGroupId(): int
    {
        return $this->groupId;
    }

    /**
     * Set the value of description
     *
     * @param string $description
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Get the value of description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the value of image
     *
     * @param string $image
     * @return void
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * Get the value of image
     *
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }
}
