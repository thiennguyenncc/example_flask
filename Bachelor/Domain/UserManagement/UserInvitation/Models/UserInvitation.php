<?php

namespace Bachelor\Domain\UserManagement\UserInvitation\Models;

use Bachelor\Domain\Base\BaseDomainModel;

class UserInvitation extends BaseDomainModel
{
    private int $userId;
    private ?string $invitationCode;
    private ?string $invitationLink;
    private ?string $promotionCode;

    public function __construct(
        int $userId,
        ?string $invitationCode = "",
        ?string $invitationLink = "",
        ?string $promotionCode = ""
    ) {
        $this->userId = $userId;
        $this->invitationCode = $invitationCode;
        $this->invitationLink = $invitationLink;
        $this->promotionCode = $promotionCode;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getInvitationCode(): ?string
    {
        return $this->invitationCode;
    }

    /**
     * @param string $invitationCode
     */
    public function setInvitationCode(?string $invitationCode): void
    {
        $this->invitationCode = $invitationCode;
    }

    /**
     * @return string
     */
    public function getInvitationLink(): ?string
    {
        return $this->invitationLink;
    }

    /**
     * @param string $invitationLink
     */
    public function setInvitationLink(?string $invitationLink): void
    {
        $this->invitationLink = $invitationLink;
    }

    /**
     * @return string
     */
    public function getPromotionCode(): ?string
    {
        return $this->promotionCode;
    }

    /**
     * @param string $promotionCode
     */
    public function setPromotionCode(?string $promotionCode): void
    {
        $this->promotionCode = $promotionCode;
    }

}
