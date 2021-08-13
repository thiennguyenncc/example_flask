<?php

namespace Bachelor\Port\Secondary\Database\FeedbackManagement\Feedback\Repository;

use Bachelor\Domain\FeedbackManagement\Feedback\Enums\CalculateableDatingReport;
use Bachelor\Domain\FeedbackManagement\Feedback\Interfaces\FeedbackRepositoryInterface;
use Bachelor\Domain\FeedbackManagement\Feedback\Models\Feedback;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\FeedbackManagement\Feedback\ModelDao\Feedback as FeedbackModelDAO;
use Illuminate\Support\Collection;

class FeedbackRepository extends EloquentBaseRepository implements FeedbackRepositoryInterface
{
    /**
     * FeedbackRepository constructor.
     * @param FeedbackModelDAO $feedbackModelDAO
     */
    public function __construct(FeedbackModelDAO $feedbackModelDAO)
    {
        parent::__construct($feedbackModelDAO);
    }

    /**
     * @param Feedback $feedback
     * @return bool
     */
    public function handleStoreFeedback(Feedback $feedback): bool
    {
        $feedbackModelDAO = $this->create([
            'dating_id' => $feedback->getDating()->getId(),
            'feedback_by' => $feedback->getFeedbackBy()->getId(),
            'feedback_for' => $feedback->getFeedbackFor()->getId(),
            'last_satisfaction' => $feedback->getLastSatisfaction(),
            'flex1' => $feedback->getFlex1(),
            'flex2' => $feedback->getFlex2(),
            'dating_place_review' => $feedback->getDatingPlaceReview(),
            'dating_place_review_comment' => $feedback->getDatingPlaceReviewComment(),
            'able_to_use_dating_place' => $feedback->getAbleToUseDatingPlace(),
            'why_not_able_to_use_dating_place' => $feedback->getWhyNotAbleToUseDatingPlace(),
            'dating_place_any_complaint' => $feedback->getDatingPlaceAnyComplaint(),
            'calculateable_dating_report' => $feedback->getCalculateableDatingReport()
        ]);
        $feedbackUserReviewModelDAO = $feedbackModelDAO->feedbackUserReview()->create([
            'feedback_id' => $feedbackModelDAO->id,
            'face_points' => $feedback->getFeedbackUserReview()->getFacePoint(),
            'personality_points' => $feedback->getFeedbackUserReview()->getPersonalityPoint(),
            'face_complaint' =>  json_encode($feedback->getFeedbackUserReview()->getFaceComplaint()),
            'face_good_factor' => json_encode($feedback->getFeedbackUserReview()->getFaceGoodFactor()),
            'face_other_comment' => $feedback->getFeedbackUserReview()->getFaceOtherComment(),
            'personality_complaint' => json_encode($feedback->getFeedbackUserReview()->getPersonalityComplaint()),
            'personality_good_factor' => json_encode($feedback->getFeedbackUserReview()->getPersonalityGoodFactor()),
            'personality_other_comment' => $feedback->getFeedbackUserReview()->getPersonalityOtherComment(),
            'behaviour_complaint' => json_encode($feedback->getFeedbackUserReview()->getBehaviourComplaint()),
            'behaviour_good_factor' => json_encode($feedback->getFeedbackUserReview()->getBehaviourGoodFactor()),
            'behaviour_other_comment' => $feedback->getFeedbackUserReview()->getBehaviourOtherComment(),
            'behaviour_points' => $feedback->getFeedbackUserReview()->getBehaviourPoint(),
            'body_shape' => $feedback->getFeedbackUserReview()->getBodyShape(),
            'the_better_point' => $feedback->getFeedbackUserReview()->getTheBetterPoint(),
            'the_worse_point' => $feedback->getFeedbackUserReview()->getTheWorsePoint(),
            'comment_something_different' => $feedback->getFeedbackUserReview()->getCommentSomethingDifferent(),
            'b_suitable' => $feedback->getFeedbackUserReview()->getBSuitable()
        ]);

        if ($feedbackUserReviewModelDAO)
        {
            return true;
        }
        return false;
    }

    /**
     * @param integer $userId
     * @param integer|null $calculateableReport
     * @param integer|null $limit
     * @param array|null $with
     * @return Collection
     */
    public function getLatestFeedbacksFor(int $userId, ?int $calculateableReport = null, ?int $limit = null, ?array $with = null): Collection
    {
        $query = $this->model->newModelQuery()->with('feedbackUserReview')
            ->where('feedback_for', $userId)
            ->where('discarded_at', null)
            ->orderBy('id', 'DESC');

        if ($calculateableReport) {
            $query->where('calculateable_dating_report', $calculateableReport);
        }

        if ($limit) {
            $query->limit($limit);
        }

        if ($with) {
            $query->with($with);
        }

        $feedbacks = $query->get();

        return $this->transformCollection($feedbacks);
    }

    /**
     * @param array $userIds
     * @param array|null $with
     * @return Collection
     */
    public function getLateFeedbacksForUserIds(array $userIds, ?int $calculateableReport = null, ?array $with = null) : Collection
    {
        $query = $this->model->newModelQuery()->with('feedbackUserReview')
            ->whereIn('feedback_for', $userIds)
            ->where('discarded_at', null)
            ->orderBy('id', 'DESC');

        if ($calculateableReport) {
            $query->where('calculateable_dating_report', $calculateableReport);
        }

        if ($with) {
            $query->with($with);
        }

        $feedbacks = $query->get();

        return $this->transformCollection($feedbacks);
    }

    /**
     * @param $userId
     * @return ?Feedback
     */
    public function getLastFeedbackOfUser($userId): ?Feedback
    {
        $feedback = $this->createQuery()
            ->where('feedback_by', $userId)
            ->orderBy('id', 'DESC')
            ->first();
        return $feedback ? $feedback->toDomainEntity() : null;
    }
}
