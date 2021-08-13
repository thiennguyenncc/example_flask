<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\ReviewBox\ModelDao;

use Bachelor\Domain\MasterDataManagement\ReviewBox\Models\ReviewBox as ReviewBoxDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\MasterDataManagement\ReviewBox\Traits\ReviewBoxRelationshipTrait;

class ReviewBox extends BaseModel
{
    use ReviewBoxRelationshipTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'review_boxes';

    protected $with = ['reviewPoint', 'starCategory'];

    public function toDomainEntity(): ReviewBoxDomainModel
    {
        $reviewBox = new ReviewBoxDomainModel(
            $this->good_bad_type,
            $this->label,
            $this->description,
            $this->feedback_by_gender,
            (int)$this->visible,
            $this->order_in_feedback,
            $this->review_point_id,
            $this->star_category_id,
        );
        $reviewBox->setId($this->getKey());
        $reviewBox->setReviewPoint($this->reviewPoint()->first()->toDomainEntity());
        $reviewBox->setStarCategory($this->starCategory()->first()->toDomainEntity());

        return $reviewBox;
    }

    /**
     * @param ReviewBoxDomainModel $reviewBox
     */
    protected function fromDomainEntity($reviewBox)
    {
        $this->id = $reviewBox->getId();
        $this->good_bad_type = $reviewBox->getGoodBadType();
        $this->label = $reviewBox->getLabel();
        $this->description = $reviewBox->getDescription();
        $this->feedback_by_gender = $reviewBox->getFeedbackByGender();
        $this->visible = $reviewBox->getVisible();
        $this->order_in_feedback = $reviewBox->getOrderInFeedback();
        $this->review_point_id = $reviewBox->getReviewPointId();
        $this->star_category_id = $reviewBox->getStarCategoryId();

        return $this;
    }
}
