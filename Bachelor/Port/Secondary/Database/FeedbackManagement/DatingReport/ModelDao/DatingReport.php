<?php

namespace Bachelor\Port\Secondary\Database\FeedbackManagement\DatingReport\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\FeedbackManagement\DatingReport\Models\DatingReport as DatingReportDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\FeedbackManagement\DatingReport\Traits\DatingReportRelationshipTrait;
use Carbon\Carbon;

class DatingReport extends BaseModel
{
    use DatingReportRelationshipTrait;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dating_reports';

    public function toDomainEntity(): DatingReportDomainModel
    {
        $datingReportGenerateFeedBacks =  $this->datingReportGenerateFeedback()->get()->transform(function ($datingReportGenerateFeedback) {
            return $datingReportGenerateFeedback->toDomainEntity();
        });
        $datingReport = new DatingReportDomainModel(
            $this->user_id,
            $datingReportGenerateFeedBacks,
            json_decode((string)$this->dating_report, true),
            Carbon::make($this->display_date),
            (int)$this->read
        );
        $datingReport->setId($this->getKey());

        return $datingReport;
    }

    protected function fromDomainEntity($model)
    {
        $this->id = $model->getId();
        $this->user_id = $model->getUserId();
        $this->dating_report = json_encode($model->getDatingReportData());
        $this->read = $model->getRead();
        $this->display_date = $model->getDisplayDate();

        return $this;
    }
}
