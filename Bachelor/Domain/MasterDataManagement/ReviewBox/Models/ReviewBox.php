<?php

namespace Bachelor\Domain\MasterDataManagement\ReviewBox\Models;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\MasterDataManagement\ReviewPoint\Models\ReviewPoint;
use Bachelor\Domain\MasterDataManagement\StarCategory\Models\StarCategory;

class ReviewBox extends BaseDomainModel
{
    /**
     * @var int
     */
    protected int $goodBadType;

    /**
     * @var string
     */
    protected string $label;

    /**
     * @var string
     */
    protected string $description;

    /**
     * @var int
     */
    protected int $feedbackByGender;

    /**
     * @var int
     */
    protected int $visible;

    /**
     * @var int
     */
    protected int $orderInFeedback;

    /**
     * @var int
     */
    protected int $reviewPointId;

    /**
     * @var int
     */
    protected int $starCategoryId;

    /**
     * @var ReviewPoint|null
     */
    protected ?ReviewPoint $reviewPoint;

    protected ?StarCategory $starCategory;

    public function __construct(int $goodBadType, string $label, string $description, int $feedbackByGender, int $visible, int $orderInFeedback, int $reviewPointId, int $starCategoryId)
    {
        $this->setGoodBadType($goodBadType);
        $this->setLabel($label);
        $this->setDescription($description);
        $this->setFeedbackByGender($feedbackByGender);
        $this->setVisible($visible);
        $this->setOrderInFeedback($orderInFeedback);
        $this->setReviewPointId($reviewPointId);
        $this->setStarCategoryId($starCategoryId);
    }

    /**
     * @return StarCategory|null
     */
    public function getStarCategory(): ?StarCategory
    {
        return $this->starCategory;
    }

    /**
     * @param StarCategory|null $starCategory
     */
    public function setStarCategory(?StarCategory $starCategory): void
    {
        $this->starCategory = $starCategory;
    }

    /**
     * @return int
     */
    public function getGoodBadType(): int
    {
        return $this->goodBadType;
    }

    /**
     * @param int $goodBadType
     */
    public function setGoodBadType(int $goodBadType): void
    {
        $this->goodBadType = $goodBadType;
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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getFeedbackByGender(): int
    {
        return $this->feedbackByGender;
    }

    /**
     * @param int $feedbackByGender
     */
    public function setFeedbackByGender(int $feedbackByGender): void
    {
        $this->feedbackByGender = $feedbackByGender;
    }

    /**
     * @return int
     */
    public function getVisible(): int
    {
        return $this->visible;
    }

    /**
     * @param int $visible
     */
    public function setVisible(int $visible): void
    {
        $this->visible = $visible;
    }

    /**
     * @return int
     */
    public function getOrderInFeedback(): int
    {
        return $this->orderInFeedback;
    }

    /**
     * @param int $orderInFeedback
     */
    public function setOrderInFeedback(int $orderInFeedback): void
    {
        $this->orderInFeedback = $orderInFeedback;
    }

    /**
     * @return int
     */
    public function getReviewPointId(): int
    {
        return $this->reviewPointId;
    }

    /**
     * @param int $reviewPointId
     */
    public function setReviewPointId(int $reviewPointId): void
    {
        $this->reviewPointId = $reviewPointId;
    }

    /**
     * @return int
     */
    public function getStarCategoryId(): int
    {
        return $this->starCategoryId;
    }

    /**
     * @param int $starCategoryId
     */
    public function setStarCategoryId(int $starCategoryId): void
    {
        $this->starCategoryId = $starCategoryId;
    }

    /**
     * @return ReviewPoint|null
     */
    public function getReviewPoint(): ?ReviewPoint
    {
        return $this->reviewPoint;
    }

    /**
     * @param ReviewPoint|null $reviewPoint
     */
    public function setReviewPoint(?ReviewPoint $reviewPoint): void
    {
        $this->reviewPoint = $reviewPoint;
    }


}
