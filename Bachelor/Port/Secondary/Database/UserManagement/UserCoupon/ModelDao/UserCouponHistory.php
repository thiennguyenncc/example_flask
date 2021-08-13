<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserCoupon\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Bachelor\Port\Secondary\Database\UserManagement\UserCoupon\Traits\UserCouponHistoryRelationshipTrait;

class UserCouponHistory extends BaseModel
{
    use HasFactory, UserCouponHistoryRelationshipTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_coupon_histories';

    /**
     * Create Domain Model object from this model DAO
     */
    public function toDomainEntity ()
    {
        // TODO: Implement toDomainEntity() method.
    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     * @param $model
     */
    protected function fromDomainEntity ( BaseDomainModel $model )
    {
        // TODO: Implement fromDomainEntity() method.
    }

}
