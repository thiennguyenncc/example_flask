<?php

namespace Bachelor\Application\User\Services\Interfaces;

use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserAuth;

interface ParticipantMainMatchServiceInterface
{
    /**
     * Get all opened dates group by week for authenticated user
     *
     * @param User $user
     * @return ParticipantMainMatchServiceInterface
     */
    public function getDatingDays(User $user): ParticipantMainMatchServiceInterface;

    /**
     * Get registered dates for user
     *
     * @param User $user
     * @return ParticipantMainMatchServiceInterface
     */
    public function getAwaitingParticipantDatingDays(User $user): ParticipantMainMatchServiceInterface;

    /**
     * User request to participate
     *
     * @param User $user
     * @param int[] $dateIds
     * @return ParticipantMainMatchServiceInterface
     */
    public function requestToParticipate(User $user, array $dateIds): ParticipantMainMatchServiceInterface;

    /**
     * User request to cancel participate
     *
     * @param User $user
     * @param int[] $dateIds
     * @return ParticipantMainMatchServiceInterface
     */
    public function requestToCancel(User $user, array $dateIds): ParticipantMainMatchServiceInterface;

    /**
     * @return array
     */
    public function handleApiResponse() : array;

    /**
     * @param User $user
     * @param array $datingDayIds
     * @return ParticipantMainMatchServiceInterface
     */
    public function requestToCancelSampleDates(User $user, array $datingDayIds): ParticipantMainMatchServiceInterface;
}
