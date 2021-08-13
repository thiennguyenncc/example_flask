<?php

namespace Bachelor\Domain\PaymentManagement\UserTrial\Interfaces;

use Bachelor\Domain\PaymentManagement\UserTrial\Models\UserTrial;
use Bachelor\Domain\UserManagement\User\Models\User;
use Illuminate\Support\Collection;

interface UserTrialRepositoryInterface
{
    /**
     * Get user trial
     *
     * @param User $user
     * @return UserTrial|null
     */
    public function getLatestTrialByUser(User $user): ?UserTrial;

    /**
     * get UserTrial Collection By EndDate
     *
     * @return Collection
     */
    public function getFinishedActiveUserTrialCollection(): Collection;

    /**
     * get All UserTrial Collection By Status
     *
     * @return Collection
     */
    public function getAllLatestUserTrialByStatus(int $status): Collection;
    
    /**
     * Save user trial
     *
     * @param UserTrial $userTrial
     * @return UserTrial
     */
    public function save(UserTrial $userTrial): UserTrial;

    /**
     * @param User $user
     * @param int $status
     * @return Collection
     */
    public function getUserTrialsByUser(User $user, int $status): Collection;

    /**
     * @param array $userIds
     * @return Collection
     */
    public function getByUserIds(array $ids): Collection;

    /**
     * @param User $user
     * @return UserTrial|null
     */
    public function getLatestUserTrialByUserIfActive(User $user): ?UserTrial;
}
