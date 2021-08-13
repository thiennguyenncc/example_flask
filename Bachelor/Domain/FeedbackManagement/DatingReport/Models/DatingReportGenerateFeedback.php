<?php


namespace Bachelor\Domain\FeedbackManagement\DatingReport\Models;


use Bachelor\Domain\Base\BaseDomainModel;

class DatingReportGenerateFeedback extends BaseDomainModel
{
    protected $feedbackId;

    protected ?int $datingReportId;

    public function __construct(int $feedbackId, ?int $datingReportId = null)
    {
        $this->setFeedbackId($feedbackId);
        $this->setDatingReportId($datingReportId);
    }

    public function setFeedbackId(int $feedbackId)
    {
        $this->feedbackId= $feedbackId;
    }

    public function getFeedbackId()
    {
        return $this->feedbackId;
    }

    public function setDatingReportId(?int $datingReportId)
    {
        $this->datingReportId= $datingReportId;
    }

    public function getDatingReportId()
    {
        return $this->datingReportId;
    }
}
