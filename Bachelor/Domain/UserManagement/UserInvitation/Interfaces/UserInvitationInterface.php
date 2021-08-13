<?php

namespace Bachelor\Domain\UserManagement\UserInvitation\Interfaces;

use Bachelor\Domain\UserManagement\UserInvitation\Models\UserInvitation as UserInvitationDomainModel;

/**
 *
 */
interface UserInvitationInterface
{
    /**
     * @param int $id
     * @return UserInvitationDomainModel|null
     */
    public function getById(int $id): ?UserInvitationDomainModel;

    /**
     * @param int $userId
     * @return UserInvitationDomainModel|null
     */
    public function retrieveUserInvitationByUserId(int $userId): ?UserInvitationDomainModel;

    /**
     * @param UserInvitationDomainModel $userInvitation
     * @return UserInvitationDomainModel
     */
    public function save(UserInvitationDomainModel $userInvitation): UserInvitationDomainModel;

    /**
     * @param string $invitationCode
     * @return UserInvitationDomainModel|null
     */
    public function retrieveUserInvitationByInvitationCode(string $invitationCode): ?UserInvitationDomainModel;
}
