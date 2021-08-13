<?php

namespace Bachelor\Domain\FeedbackManagement\Feedback\Models;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\DatingManagement\Dating\Models\Dating;
use Bachelor\Domain\UserManagement\User\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class Feedback extends BaseDomainModel
{
    /**
     * @var User
     */
    protected $feedbackBy ;

    /**
     * @var User
     */
    protected $feedbackFor;

    /**
     * @var Dating
     */
    protected $dating;

    /**
     * @var int
     */
    protected $lastSatisfaction;

    /**
     * @var FeedbackUserReview
     */
    protected $feedbackUserReview;

    /**
     * @var int
     */
    protected $datingPlaceReview;

    /**
     * @var int
     */
    protected $flex1;

    /**
     * @var int
     */
    protected $flex2;

    /**
     * @var Carbon
     */
    protected $discardedAt;

    /**
     * @var string
     */
    protected $datingPlaceReviewComment;

    /**
     * @var int
     */
    protected $ableToUseDatingPlace;

    /**
     * @var int
     */
    protected $whyNotAbleToUseDatingPlace;

    /**
     * @var string
     */
    protected $datingPlaceAnyComplaint;

    /**
     * @var int
     */
    protected $calculateableDatingReport;

    /**
     * @var Collection
     */
    protected ?Collection $datingReportGenerateFeedbacks = null;

    public function setFeedbackBy(User $user)
    {
        $this->feedbackBy = $user;
    }

    public function getFeedbackBy(): User
    {
        return $this->feedbackBy;
    }

    public function setFeedbackFor(User $user)
    {
        $this->feedbackFor = $user;
    }

    public function getFeedbackFor(): User
    {
        return $this->feedbackFor;
    }

    public function setDating(Dating $dating)
    {
        $this->dating = $dating;
    }

    public function getDating(): Dating
    {
        return $this->dating;
    }

    public function setLastSatisfaction(int $lastSatisfaction)
    {
        $this->lastSatisfaction = $lastSatisfaction;
    }

    public function getLastSatisfaction(): int
    {
        return $this->lastSatisfaction;
    }

    public function setFeedbackUserReview(FeedbackUserReview $feedbackUserReview)
    {
        $this->feedbackUserReview = $feedbackUserReview;
    }

    public function getFeedbackUserReview(): FeedbackUserReview
    {
        return $this->feedbackUserReview;
    }

    public function setDatingPlaceReview(int $datingPlaceReview)
    {
        $this->datingPlaceReview = $datingPlaceReview;
    }

    public function getDatingPlaceReview(): int
    {
        return $this->datingPlaceReview;
    }

    public function setFlex1(int $flex1)
    {
        $this->flex1 = $flex1;
    }

    public function getFlex1(): int
    {
        return $this->flex1;
    }

    public function setFlex2(int $flex2)
    {
        $this->flex2 = $flex2;
    }

    public function getFlex2(): int
    {
        return $this->flex2;
    }

    public function setDiscardedAt(?Carbon $discardedAt)
    {
        $this->discardedAt = $discardedAt;
    }

    public function getDiscardedAt(): ?Carbon
    {
        return $this->discardedAt;
    }

    public function setDatingPlaceReviewComment(string $datingPlaceReviewComment)
    {
        $this->datingPlaceReviewComment = $datingPlaceReviewComment;
    }

    public function getDatingPlaceReviewComment(): string
    {
        return $this->datingPlaceReviewComment;
    }

    public function setAbleToUseDatingPlace(int $ableToUseDatingPlace)
    {
        $this->ableToUseDatingPlace = $ableToUseDatingPlace;
    }

    public function getAbleToUseDatingPlace(): int
    {
        return $this->ableToUseDatingPlace;
    }

    public function setWhyNotAbleToUseDatingPlace(int $whyNotAbleToUseDatingPlace)
    {
        $this->whyNotAbleToUseDatingPlace = $whyNotAbleToUseDatingPlace;
    }

    public function getWhyNotAbleToUseDatingPlace(): int
    {
        return $this->whyNotAbleToUseDatingPlace;
    }

    public function setDatingPlaceAnyComplaint($datingPlaceAnyComplaint)
    {
        $this->datingPlaceAnyComplaint = $datingPlaceAnyComplaint;
    }

    public function getDatingPlaceAnyComplaint(): string
    {
        return $this->datingPlaceAnyComplaint;
    }

    public function setCalculateableDatingReport($calculateableDatingReport)
    {
        $this->calculateableDatingReport = $calculateableDatingReport;
    }

    public function getCalculateableDatingReport(): int
    {
        return $this->calculateableDatingReport;
    }

    public function setDatingReportGenerateFeedbacks(Collection $datingReportGenerateFeedbacks)
    {
        $this->datingReportGenerateFeedbacks = $datingReportGenerateFeedbacks;
    }

    public function getDatingReportGenerateFeedbacks(): ?Collection
    {
        return $this->datingReportGenerateFeedbacks;
    }
}
