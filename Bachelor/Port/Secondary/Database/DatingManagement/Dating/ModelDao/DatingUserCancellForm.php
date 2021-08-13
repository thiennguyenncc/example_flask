<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao;

use Bachelor\Domain\DatingManagement\Dating\Models\DatingUserCancellForm as DatingUserCancellFormDomainEntity;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\DatingManagement\Dating\Traits\DatingUserCancellFormRelationshipTrait;

class DatingUserCancellForm extends BaseModel
{
    use DatingUserCancellFormRelationshipTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dating_user_cancel_form';

    /**
     * @return DatingUserCancellFormDomainEntity
     */
    public function toDomainEntity(): DatingUserCancellFormDomainEntity
    {
        $datingUserCancellForm = new DatingUserCancellFormDomainEntity(
            $this->datingUser()->first()->id,
            explode(",",$this->reason_for_cancellation),
            $this->reason_for_cancellation_other_text,
            $this->reason_for_cancellation_dissatisfaction_other_text,
            $this->detailed_reason,
        );
        $datingUserCancellForm->setId($this->getKey());

        return $datingUserCancellForm;
    }

    /**
     * @param DatingUserCancellFormDomainEntity $datingUserCancellForm
     * @return self
     */
    protected function fromDomainEntity($datingUserCancellForm)
    {
        $this->id = $datingUserCancellForm->getId();
        $this->dating_user_id = $datingUserCancellForm->getDatingUserId();
        $this->reason_for_cancellation = implode(",",$datingUserCancellForm->getReasonForCancellation());
        $this->reason_for_cancellation_other_text = $datingUserCancellForm->getReasonForCancellationOtherText();
        $this->reason_for_cancellation_dissatisfaction_other_text = $datingUserCancellForm->getReasonForCancellationDissatisfactionOtherText();
        $this->detailed_reason = $datingUserCancellForm->getDetailedReason();

        return $this;
    }
}
