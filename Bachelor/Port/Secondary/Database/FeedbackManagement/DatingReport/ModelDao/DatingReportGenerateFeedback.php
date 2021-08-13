<?php

namespace Bachelor\Port\Secondary\Database\FeedbackManagement\DatingReport\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\FeedbackManagement\DatingReport\Models\DatingReportGenerateFeedback as DatingReportGenerateFeedbackEntity;
use Bachelor\Port\Secondary\Database\Base\BaseModel;

class DatingReportGenerateFeedback extends BaseModel
{
    protected $table = 'dating_report_generate_feedback';


    public function toDomainEntity(): DatingReportGenerateFeedbackEntity
    {
        $datingReportGenerateFeedback = new DatingReportGenerateFeedbackEntity(
            $this->feedback_id,
            $this->dating_report_id
        );
        $datingReportGenerateFeedback->setId($this->getKey());

        return $datingReportGenerateFeedback;
    }

    protected function fromDomainEntity(BaseDomainModel $model)
    {
        $this->feedback_id = $model->getFeedbackId();
        $this->dating_report_id = $model->getDatingReportId();

        return $this;
    }
}
