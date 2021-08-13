<?php

namespace Bachelor\Port\Secondary\Database\UserManagement\UserInvitation\ModelDao;

use Bachelor\Domain\UserManagement\UserInvitation\Models\UserInvitation as UserInvitationDomainModel;
use Bachelor\Port\Secondary\Database\Base\BaseModel;
use Bachelor\Port\Secondary\Database\UserManagement\UserInvitation\Traits\UserInvitationRelationshipTrait;

class UserInvitation extends BaseModel
{
    use UserInvitationRelationshipTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_invitation';

    /**
     * @return UserInvitationDomainModel
     */
    public function toDomainEntity(): UserInvitationDomainModel
    {
        $userInvitation = new UserInvitationDomainModel(
            $this->user_id,
            $this->invitation_code,
            $this->invitation_link,
            $this->promotion_code
        );
        $userInvitation->setId($this->getKey());

        return $userInvitation;
    }

    /**
     * @param UserInvitationDomainModel $userInvitation
     * @return UserInvitation
     */
    protected function fromDomainEntity($userInvitation)
    {
        $this->id = $userInvitation->getId();
        $this->user_id = $userInvitation->getUserId();
        $this->invitation_code = $userInvitation->getInvitationCode();
        $this->invitation_link = $userInvitation->getInvitationLink();
        $this->promotion_code = $userInvitation->getPromotionCode();

        return $this;
    }
}
