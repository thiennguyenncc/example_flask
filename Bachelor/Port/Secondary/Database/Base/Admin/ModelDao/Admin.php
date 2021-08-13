<?php

namespace Bachelor\Port\Secondary\Database\Base\Admin\ModelDao;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Port\Secondary\Database\Base\Admin\Traits\HasFactory;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\Base\Admin\Traits\AdminRelationshipTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Admin extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use AdminRelationshipTrait, Authenticatable, Authorizable, CanResetPassword, HasApiTokens, Notifiable, HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'admins';

    /**
     * @var string[]
     */
    protected $hidden = [
        'password' ,
        'remember_token' ,
        'created_at' ,
        'updated_at'
    ];

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
