<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\DatingDay\ModelDao;

use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay as DatingDayDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\DatingManagement\DatingDay\Traits\DatingDayRelationship;
use Bachelor\Port\Secondary\Database\DatingManagement\DatingDay\Traits\HasFactory;

class DatingDay extends BaseModel
{
    use DatingDayRelationship, HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dating_days';

    /**
     * @return DatingDayDomainModel
     */
    public function toDomainEntity(): DatingDayDomainModel
    {
        $model = new DatingDayDomainModel(
            $this->dating_day,
            $this->dating_date,
        );
        $model->setId($this->getKey());

        return $model;
    }

    /**
     * @param DatingDayDomainModel $model
     * @return DatingDay
     */
    protected function fromDomainEntity($model)
    {
        $this->id = $model->getId();
        $this->dating_day = $model->getDatingDayOfWeek();
        $this->dating_date = $model->getDatingDate();

        return $this;
    }
}
