<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserProfile\Repository;

use Bachelor\Domain\UserManagement\UserProfile\Interfaces\UserImageInterface;
use Bachelor\Domain\UserManagement\UserProfile\Models\UserImage as UserImageDomainModel;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\UserManagement\UserProfile\ModelDao\UserImage;
use Illuminate\Support\Collection;

/**
 *
 */
class UserImageRepository extends EloquentBaseRepository implements UserImageInterface
{
    /**
     * EloquentUserProfileRepository constructor.
     * @param UserImage $model
     */
    public function __construct(UserImage $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @return UserImageDomainModel|null
     */
    public function getById(int $id): ?UserImageDomainModel
    {
        $modelDao = $this->createQuery()->where('id', $id)->first();

        return $modelDao ? $modelDao->toDomainEntity() : null;
    }

    /**
     * @param UserImageDomainModel $userImage
     * @return UserImageDomainModel
     */
    public function save(UserImageDomainModel $userImage): UserImageDomainModel
    {
        return $this->createModelDAO($userImage->getId())->saveData($userImage);
    }

    /**
     * @param int $userId
     * @return Collection|null
     */
    public function retrieveUserImageByUserId(int $userId): ?Collection
    {
        $modelDao = $this->createQuery()->where('user_id', $userId)->get();

        return $this->transformCollection($modelDao);
    }
}
