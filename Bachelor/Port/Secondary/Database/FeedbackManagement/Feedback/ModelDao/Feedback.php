<?php


namespace Bachelor\Port\Secondary\Database\FeedbackManagement\Feedback\ModelDao;


use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\FeedbackManagement\Feedback\Models\Feedback as FeedbackDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\FeedbackManagement\Feedback\Traits\FeedbackRelationshipTrait;
use Bachelor\Port\Secondary\Database\FeedbackManagement\Feedback\Traits\HasFactory;
use Carbon\Carbon;

class Feedback extends BaseModel
{
    use FeedbackRelationshipTrait, HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'feedbacks';

    public function toDomainEntity()
    {
        $feedback = new FeedbackDomainModel();
        $feedback->setFeedbackBy($this->feedbackBy()->first()->toDomainEntity());
        $feedback->setFeedbackFor($this->feedbackFor()->first()->toDomainEntity());
        $feedback->setDating($this->dating()->first()->toDomainEntity());
        $feedback->setLastSatisfaction((float)$this->last_satisfaction);
        $feedback->setFeedbackUserReview($this->feedbackUserReview()->first()->toDomainEntity());
        $feedback->setDatingPlaceReview((int)$this->dating_place_review);
        $feedback->setFlex1((int)$this->flex1);
        $feedback->setFlex2((int)$this->flex2);
        $feedback->setDiscardedAt(Carbon::parse($this->discardedAt));
        $feedback->setId($this->getKey());

        if ($this->relationloaded('datingReportGenerateFeedbacks')) {
            $feedback->setDatingReportGenerateFeedbacks($this->datingReportGenerateFeedbacks()->get()->transform(function ($drgFeedback) {
                return $drgFeedback->toDomainEntity();
            }));
        }

        return $feedback;

    }

    protected function fromDomainEntity(BaseDomainModel $model)
    {
        // TODO: Implement fromDomainEntity() method.
    }
}
