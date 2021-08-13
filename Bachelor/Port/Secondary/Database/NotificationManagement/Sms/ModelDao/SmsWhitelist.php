<?php

namespace Bachelor\Port\Secondary\Database\NotificationManagement\Sms\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;

class SmsWhitelist extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sms_whitelist';

    public function toDomainEntity()
    {
        // TODO: Implement toDomainEntity() method.
    }

    protected function fromDomainEntity(BaseDomainModel $model)
    {
        // TODO: Implement fromDomainEntity() method.
    }
}
