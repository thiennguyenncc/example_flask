<?php

namespace Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces;

use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Model\ParticipantMainMatch;
use Bachelor\Domain\UserManagement\User\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Carbon\Carbon;
use Illuminate\Support\Collection;

interface ParticipantMainMatchRepositoryInterface
{
    /**
     * @param int $prefectureId
     * @param int $datingDayId
     * @return array
     */
    public function getCountPerGenderByPrefectureAndDatingDay(int $prefectureId, int $datingDayId, ?array $statuses = null): Collection;

    /**
     * @return Paginator
     */
    public function listAwaitingParticipantsWithPaginator(): Paginator;

    /**
     * Get all awaiting participation requests for one user
     *
     * @param User $user
     * @return Collection | ParticipantMainMatch[]
     */
    public function getAwaitingForUser(User $user): Collection;

    /**
     * Get all sample participants for one user
     *
     * @param User $user
     * @return Collection | ParticipantMainMatch[]
     */
    public function getParticipantsHaveSampleDateForUser(User $user): Collection;

    /**
     * @param array | int[] $userIds
     * @return Collection | ParticipantMainMatch[]
     */
    public function getParticipantsByUserIds(array $userIds, ?array $statuses = null, ?array $relations = null): Collection;

    /**
     * @param User $user
     * @param DatingDay $datingDay
     * @param array|null $relations
     * @return ParticipantMainMatch|null
     */
    public function getAwaitingByUserAndDate(User $user, DatingDay $datingDay, ?array $relations = null): ?ParticipantMainMatch;

    /**
     * @param Collection | User[] $users
     * @param Carbon $dayInWeek
     * @return Collection | ParticipantMainMatch[]
     */
    public function getAwaitingForUsersInSameWeek(Collection|array $users, Carbon $dayInWeek): Collection;

    /**
     * @param User $user
     * @param string $from format Y-m-d
     * @return Collection | ParticipantMainMatch[]
     */
    public function getParticipatedHistoryForUser(User $user, string $from = ''): Collection;

    /**
     * Get all participated days in same week
     *
     * @param User $user
     * @param Carbon $dayInWeek
     * @return Collection | ParticipantMainMatch[]
     */
    public function getParticipatedHistoryForUserInSameWeek(User $user, Carbon $dayInWeek): Collection;

    /**
     * @param [] $userIds
     * @param Carbon $dayInWeek
     * @return Collection | ParticipantMainMatch[]
     */
    public function getParticipatedHistoryForUsersInSameWeek(array $userIds, Carbon $dayInWeek): Collection;

    /**
     * @param ParticipantMainMatch $participantMainMatch
     * @return ParticipantMainMatch
     */
    public function save(ParticipantMainMatch $participantMainMatch): ParticipantMainMatch;

    /**
     * Reset last weeks
     *
     * @param int $weekOffset
     * @return bool
     * @throws \Exception
     */
    public function removeParticipantsInWeek(int $weekOffset = 0): bool;

    /**
     * @param array $formattedImportData
     * @return array ['success' => [], 'failure' => []]
     * @deprecated
     * Import participants
     *
     */
    public function importParticipants(array $formattedImportData): array;

    /**
     * @param User $user
     * @param DatingDay $datingDay
     * @return ParticipantMainMatch|null
     */
    public function getLatestByUserAndDay(User $user, DatingDay $datingDay): ?ParticipantMainMatch;

    /**
     * @param Carbon $datingDate
     * @param int $status
     * @return Collection
     */
    public function getParticipantsByStatusAndDate(int $status, Carbon $datingDate): Collection;

    /**
     * @param int $status
     * @param Carbon $dayInWeek
     * @return Collection
     */
    public function getParticipantsForFakeUserByStatusAndDate(int $status, Carbon $dayInWeek): Collection;

    /**
     * @param int $prefectureId
     * @param int $datingDayId
     * @param array|null $statuses
     * @param array|null $with
     * @return Collection
     */
    public function getParticipantMainMatchByPrefectureAndDatingDay(int $prefectureId, int $datingDayId, ?array $statuses, ?array $with = null): Collection;

    /**
     *
     * @return Collection|null
     */
    public function getAllNotCompletedRegistrationByStatus(int $status): ?Collection;
}
