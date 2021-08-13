<?php

namespace Bachelor\Port\Secondary\Database\FeedbackManagement\Feedback\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\FeedbackManagement\Feedback\Models\FeedbackUserReview as FeedbackUserReviewDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\FeedbackManagement\Feedback\Traits\FeedbackUserReviewRelationshipTrait;

class FeedbackUserReview extends BaseModel
{
    use FeedbackUserReviewRelationshipTrait;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'feedback_user_reviews';

    public function toDomainEntity()
    {
        $feedbackUserReview = new FeedbackUserReviewDomainModel();
        $feedbackUserReview->setFeedbackId((int)$this->feedback_id);
        $feedbackUserReview->setFacePoint((int)$this->face_points);
        $feedbackUserReview->setPersonalityPoint((int)$this->personality_points);
        $feedbackUserReview->setBehaviourPoint((int)$this->behaviour_points);
        $feedbackUserReview->setFaceComplaint((string)$this->face_complaint);
        $feedbackUserReview->setFaceGoodFactor((string)$this->face_good_factor);
        $feedbackUserReview->setPersonalityComplaint((string)$this->personality_complaint);
        $feedbackUserReview->setPersonalityGoodFactor((string)$this->personality_good_factor);
        $feedbackUserReview->setBehaviourComplaint((string)$this->behaviour_complaint);
        $feedbackUserReview->setBehaviourGoodFactor((string)$this->behaviour_good_factor);
        $feedbackUserReview->setBodyShape((float)$this->body_shape);
        $feedbackUserReview->setBSuitable((float)$this->b_suitable);
        $feedbackUserReview->setIsOldReview((int)$this->is_old_review);
        $feedbackUserReview->setUseCalculateDatingReport((int)$this->use_calculate_dating_report);
        $feedbackUserReview->setId($this->getKey());

        return $feedbackUserReview;
    }

    protected function fromDomainEntity(BaseDomainModel $model)
    {
        // TODO: Implement fromDomainEntity() method.
    }
}
