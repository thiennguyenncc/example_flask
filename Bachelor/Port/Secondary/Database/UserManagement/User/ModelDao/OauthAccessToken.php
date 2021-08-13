<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OauthAccessToken extends BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'oauth_access_tokens';

    /**
     * Get the user to which this id belongs to
     *
     * @return BelongsTo
     */
    public function userAuth()
    {
        return $this->belongsTo(UserAuth::class, 'user_id');
    }

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
