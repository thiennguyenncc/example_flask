<?php
namespace Bachelor\Domain\DatingManagement\ParticipantForRematch\Interfaces;

use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Models\ParticipantForRematch;
use Bachelor\Domain\UserManagement\User\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

interface ParticipantForRematchRepositoryInterface
{
    /**
     * Save Record
     *
     * @param ParticipantForRematch $participantForRematch
     * @return ParticipantForRematch|null
     */
    public function save(ParticipantForRematch $participantForRematch): ?ParticipantForRematch;

    /**
     * Get all awaiting participation requests for one user
     *
     * @param User $user
     * @return Collection [ParticipantForRematch]
     */
    public function getAwaitingForUser(User $user): Collection;

    /**
     * @param User $user
     * @param DatingDay $datingDay
     * @return ParticipantForRematch|null
     */
    public function getByUserAndDatingDay(User $user, DatingDay $datingDay): ?ParticipantForRematch;

    /**
     * @param int $status
     * @param Carbon $dayInWeek
     * @param bool $isForTrialUser
     * @param int|null $gender
     * @return Collection
     */
    public function getParticipantsRematchingByStatusAndDate(int $status, Carbon $dayInWeek, bool $isForTrialUser = false, ?int $gender = null): Collection;

    /**
     * Reset last weeks
     *
     * @param int $weekOffset
     * @return bool
     */
    public function removeParticipantsInWeek(int $weekOffset = 0): bool;
}
