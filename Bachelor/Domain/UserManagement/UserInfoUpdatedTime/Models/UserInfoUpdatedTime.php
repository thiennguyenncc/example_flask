<?php
namespace Bachelor\Domain\UserManagement\UserInfoUpdatedTime\Models;

use Bachelor\Domain\Base\BaseDomainModel;
use Bachelor\Domain\UserManagement\User\Models\User;
use Carbon\Carbon;

class UserInfoUpdatedTime extends BaseDomainModel
{
    private int $userId;
    private ?Carbon $approvedAt;
    private ?Carbon $firstRegistrationCompletedAt;
    private ?User $user;

    public function __construct(
        int $userId,
        ?Carbon $approvedAt = null,
        ?Carbon $firstRegistrationCompletedAt = null
    )
    {
        $this->userId = $userId;
        $this->approvedAt = $approvedAt;
        $this->firstRegistrationCompletedAt = $firstRegistrationCompletedAt;
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
     * @return Carbon
     */
    public function getApprovedAt(): ?Carbon
    {
        return $this->approvedAt;
    }

    /**
     * @param Carbon $approvedAt
     */
    public function setApprovedAt(?Carbon $approvedAt): void
    {
        $this->approvedAt = $approvedAt;
    }

    /**
     * @return Carbon|null
     */
    public function getFirstRegistrationCompletedAt(): ?Carbon
    {
        return $this->firstRegistrationCompletedAt;
    }

    /**
     * @param Carbon $firstRegistrationCompletedAt
     */
    public function setFirstRegistrationCompletedAt(?Carbon $firstRegistrationCompletedAt): void
    {
        $this->firstRegistrationCompletedAt = $firstRegistrationCompletedAt;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
