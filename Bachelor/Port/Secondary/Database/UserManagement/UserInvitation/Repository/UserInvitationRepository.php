<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserInvitation\Repository;

use Bachelor\Domain\UserManagement\UserInvitation\Interfaces\UserInvitationInterface;
use Bachelor\Domain\UserManagement\UserInvitation\Models\UserInvitation as UserInvitationDomainModel;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\UserManagement\UserInvitation\ModelDao\UserInvitation;

/**
 *
 */
class UserInvitationRepository extends EloquentBaseRepository implements UserInvitationInterface
{
    /**
     * EloquentUserInvitationRepository constructor.
     * @param UserInvitation $model
     */
    public function __construct(UserInvitation $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @return UserInvitationDomainModel|null
     */
    public function getById(int $id): ?UserInvitationDomainModel
    {
        $modelDao = $this->createQuery()->where('id', $id)->first();

        return $modelDao ? $modelDao->toDomainEntity() : null;
    }

    /**
     * @param UserInvitationDomainModel $userInvitation
     * @return UserInvitationDomainModel
     */
    public function save(UserInvitationDomainModel $userInvitation): UserInvitationDomainModel
    {
        return $this->createModelDAO($userInvitation->getId())->saveData($userInvitation);
    }

    /**
     * @param int $userId
     * @return UserInvitationDomainModel|null
     */
    public function retrieveUserInvitationByUserId(int $userId): ?UserInvitationDomainModel
    {
        $modelDao = $this->createQuery()->where('user_id', $userId)->first();

        return $modelDao ? $modelDao->toDomainEntity() : null;
    }

    /**
     * @param string $invitationCode
     * @return UserInvitationDomainModel|null
     */
    public function retrieveUserInvitationByInvitationCode(string $invitationCode): ?UserInvitationDomainModel
    {
        $modelDao = $this->createQuery()->where('invitation_code', $invitationCode)->first();

        return $modelDao ? $modelDao->toDomainEntity() : null;
    }
}
