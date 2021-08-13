<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserProfile\ModelDao;

use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\UserManagement\UserProfile\Traits\UserImageRelationshipTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Bachelor\Domain\UserManagement\UserProfile\Models\UserImage as UserImageDomainModel;

class UserImage extends BaseModel
{
    use HasFactory, UserImageRelationshipTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_images';

    /**
     * Create Domain Model object from this model DAO
     */
    public function toDomainEntity (): UserImageDomainModel
    {
        $model = new UserImageDomainModel(
            $this->user_id,
            $this->file_name,
            $this->is_primary,
        );

        $model->setId($this->id);
        return $model;
    }

    /**
     * Pull data from Domain Model object to this model DAO for saving
     * @param UserImageDomainModel $model
     */
    protected function fromDomainEntity ($model)
    {
        $this->user_id = $model->getUserId();
        $this->file_name = $model->getFileName();
        $this->is_primary = $model->getIsPrimary();

        return $this;
    }

}
