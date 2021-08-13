<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\Payment\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\PaymentManagement\Subscription\ModelDao\Subscription;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;

class WebhookLog extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'webhook_logs';

    /**
     * Create Domain Model object from this model DAO
     */
    public function toDomainEntity ()
    {
        // TODO
    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     * @param $model
     * @return WebhookLog
     */
    protected function fromDomainEntity ( BaseDomainModel $model )
    {
        return $this;
    }

    /**
     * @return mixed
     */
    protected function user()
    {
        return $this->belongsTo(User::class)->toDomainEntity();
    }

    /**
     * @return mixed
     */
    protected function subscription()
    {
        return $this->belongsTo(Subscription::class)->toDomainEntity();
    }

}
