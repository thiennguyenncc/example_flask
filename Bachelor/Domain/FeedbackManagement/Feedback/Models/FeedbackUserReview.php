<?php

namespace Bachelor\Domain\FeedbackManagement\Feedback\Models;

use Bachelor\Domain\Base\BaseDomainModel;

class FeedbackUserReview extends BaseDomainModel
{
    /**
     * @var int
     */
    protected $feedbackId;

    /**
     * @var int
     */
    protected $facePoint;

    /**
     * @var int
     */
    protected $personalityPoint;

    /**
     * @var int
     */
    protected $behaviourPoint;

    /**
     * @var string
     */
    protected $faceComplaint;

    /**
     * @var string
     */
    protected $faceGoodFactor;

    /**
     * @var string
     */
    protected $faceOtherComment;

    /**
     * @var string
     */
    protected $personalityComplaint;

    /**
     * @var string
     */
    protected $personalityGoodFactor;

    /**
     * @var string
     */
    protected $personalityOtherComment;

    /**
     * @var string
     */
    protected $behaviourComplaint;

    /**
     * @var string
     */
    protected $behaviourGoodFactor;

    /**
     * @var string
     */
    protected $behaviourOtherComment;

    /**
     * @var int
     */
    protected $bSuitable;

    /**
     * @var int
     */
    protected $bodyShape;

    /**
     * @var string
     */
    protected $theBetterPoint;

    /**
     * @var string
     */
    protected $theWorsePoint;

    /**
     * @var string
     */
    protected $commentSomethingDifferent;

    /**
     * @var int
     */
    protected $isOldReview;

    /**
     * @var int
     */
    protected $useCalculateDatingReport;

    public function setFeedbackId($feedbackId)
    {
        $this->feedbackId = $feedbackId;
    }

    public function getFeedbackId(): int
    {
        return $this->feedbackId;
    }

    public function setFacePoint($facePoint)
    {
        $this->facePoint = $facePoint;
    }

    public function getFacePoint(): int
    {
        return $this->facePoint;
    }

    public function setPersonalityPoint($personalityPoint)
    {
        $this->personalityPoint = $personalityPoint;
    }

    public function getPersonalityPoint(): int
    {
        return $this->personalityPoint;
    }

    public function setBehaviourPoint($behaviourPoint)
    {
        $this->behaviourPoint = $behaviourPoint;
    }

    public function getBehaviourPoint(): int
    {
        return $this->behaviourPoint;
    }

    public function setFaceComplaint($faceComplaint)
    {
        $this->faceComplaint = $faceComplaint;
    }

    public function getFaceComplaint(): array
    {

        return json_decode($this->faceComplaint) ?? [];
    }

    public function setFaceGoodFactor($faceGoodFactor)
    {
        $this->faceGoodFactor = $faceGoodFactor;
    }

    public function getFaceGoodFactor(): array
    {
        return json_decode($this->faceGoodFactor) ?? [];
    }

    public function setFaceOtherComment($faceOtherComment)
    {
        $this->faceOtherComment = $faceOtherComment;
    }

    public function getFaceOtherComment(): string
    {
        return $this->faceOtherComment;
    }

    public function setPersonalityComplaint($personalityComplaint)
    {
        $this->personalityComplaint = $personalityComplaint;
    }

    public function getPersonalityComplaint(): array
    {
        return json_decode($this->personalityComplaint) ?? [];
    }

    public function setPersonalityGoodFactor($personalityGoodFactor)
    {
        $this->personalityGoodFactor = $personalityGoodFactor;
    }

    public function getPersonalityGoodFactor(): array
    {
        return json_decode($this->personalityGoodFactor) ?? [];
    }

    public function setPersonalityOtherComment($personalityOtherComment)
    {
        $this->personalityOtherComment = $personalityOtherComment;
    }

    public function getPersonalityOtherComment(): string
    {
        return $this->personalityOtherComment;
    }

    public function setBehaviourComplaint($behaviourComplaint)
    {
        $this->behaviourComplaint = $behaviourComplaint;
    }

    public function getBehaviourComplaint(): array
    {
        return json_decode($this->behaviourComplaint) ?? [];
    }

    public function setBehaviourGoodFactor($behaviourGoodFactor)
    {
        $this->behaviourGoodFactor = $behaviourGoodFactor;
    }

    public function getBehaviourGoodFactor(): array
    {
        return json_decode($this->behaviourGoodFactor) ?? [];
    }

    public function setBehaviourOtherComment($behaviourOtherComment)
    {
        $this->behaviourOtherComment = $behaviourOtherComment;
    }

    public function getBehaviourOtherComment(): string
    {
        return $this->behaviourOtherComment;
    }

    public function setBSuitable($bSuitable)
    {
        $this->bSuitable = $bSuitable;
    }

    public function getBSuitable(): int
    {
        return $this->bSuitable;
    }

    public function setBodyShape($bodyShape)
    {
        $this->bodyShape = $bodyShape;
    }

    public function getBodyShape(): int
    {
        return $this->bodyShape;
    }

    public function setTheBetterPoint($theBetterPoint)
    {
        $this->theBetterPoint = $theBetterPoint;
    }

    public function getTheBetterPoint(): string
    {
        return $this->theBetterPoint;
    }

    public function setTheWorsePoint($theWorsePoint)
    {
        $this->theWorsePoint = $theWorsePoint;
    }

    public function getTheWorsePoint(): string
    {
        return $this->theWorsePoint;
    }

    public function setCommentSomethingDifferent($commentSomethingDifferent)
    {
        $this->commentSomethingDifferent = $commentSomethingDifferent;
    }

    public function getCommentSomethingDifferent(): string
    {
        return $this->commentSomethingDifferent;
    }

    /**
     * @return int
     */
    public function getIsOldReview(): int
    {
        return $this->isOldReview;
    }

    /**
     * @param int $isOldReview
     */
    public function setIsOldReview(int $isOldReview): void
    {
        $this->isOldReview = $isOldReview;
    }

    /**
     * @return int
     */
    public function getUseCalculateDatingReport(): int
    {
        return $this->useCalculateDatingReport;
    }

    /**
     * @param int $useCalculateDatingReport
     */
    public function setUseCalculateDatingReport(int $useCalculateDatingReport): void
    {
        $this->useCalculateDatingReport = $useCalculateDatingReport;
    }
}
