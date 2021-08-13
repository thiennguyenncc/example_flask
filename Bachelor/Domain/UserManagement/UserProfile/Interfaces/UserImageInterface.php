<?php

namespace Bachelor\Domain\UserManagement\UserProfile\Interfaces;

use Bachelor\Domain\UserManagement\UserProfile\Models\UserImage;
use Illuminate\Support\Collection;

/**
 *
 */
interface UserImageInterface
{
    /**
     * @param int $id
     * @return UserImage|null
     */
    public function getById(int $id): ?UserImage;

    /**
     * @param int $userId
     * @return Collection|null
     */
    public function retrieveUserImageByUserId(int $userId): ?Collection;

    /**
     * @param UserImage $userImage
     * @return UserImage
     */
    public function save(UserImage $userImage): UserImage;

}
