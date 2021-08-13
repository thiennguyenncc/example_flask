<?php

namespace Bachelor\Domain\DatingManagement\Dating\Interfaces;

use Bachelor\Domain\DatingManagement\Dating\Models\Dating;
use Bachelor\Domain\DatingManagement\Dating\Models\DatingUser;
use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\UserManagement\User\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

interface DatingRepositoryInterface
{
    /**
     * @param integer $datingId
     * @param integer|null $status
     * @param array|null $with
     * @return Dating|null
     */
    public function getDatingById(int $datingId, ?int $status = null, ?array $with = null): ?Dating;


    /**
     * Get dating history
     *
     * @param Carbon|null $from
     * @param Carbon|null $to
     * @param int|null $status
     * @param array|null $with
     * @param string|null $search
     * @param int|null $isFake
     * @param string|null $datingDate
     * @param string|null $startTime
     * @return Collection
     */
    public function getDatingsFromTo(?Carbon $from = null, ?Carbon $to = null, ?int $status = null, ?array $with = null, ?string $search = "", ?int $isFake = null, ?string $datingDate = null, ?string $startTime = null): Collection;

    /**
     * Get datings by user id
     *
     * @param int $userId
     * @param int|null $status
     * @param int|null $datingDayId
     * @return Collection
     */
    public function getDatingsByUserId(int $userId, ?int $status = null, ?int $datingDayId = null): Collection;

    /**
     * Get incompeted datings by dating day id
     *
     * @param int $datingDayId
     * @return Collection
     */
    public function getIncompletedDatingsByDatingDay(int $datingDayId): Collection;

    /**
     * @param integer $userId
     * @param integer|null $status
     * @param integer|null $partnerId
     * @return Dating|null
     */
    public function getLatestDatingByUserId(int $userId, ?int $status = null, ?int $partnerId = null): ?Dating;

    /**
     * Get datings no feedback by user id
     *
     * @param int $userId
     * @param int|null $status
     * @return Collection
     */
    public function getDatingsNoFeedbackByUserId(int $userId, ?int $status = null): Collection;

    /**
     * get not completed Dating
     *
     * @param User $user
     * @return Dating
     */
    public function getNotCompletedDatings(User $user): Collection;

    /**
     * Remove all Imcomplete Dating
     *
     * @param int $weekOffset
     * @return bool
     */
    public function deleteDatingsInWeek(int $weekOffset = 0): bool;

    /**
     * @param Dating $dating
     * @return Dating
     */
    public function save(Dating $dating): Dating;

    /**
     * Get datings completed today
     *
     * @return Collection
     */
    public function getDatingsCompletedToday(): Collection;

    /**
     * Get completed datings without feedback
     *
     * @param Carbon|null $fro
     * @param Carbon|null $to
     * @return Collection
     */
    public function getCompletedDatingWithoutFeedback(?Carbon $from = null, ?Carbon $to = null): Collection;

    /**
     * @param Carbon $from
     * @param Carbon $to
     * @param int $status
     * @return Collection
     */
    public function getDatingsHasFeedbacksFromTo(Carbon $from, Carbon $to, int $status): Collection;

    /**
     * @param User $user
     * @param DatingDay $datingDay
     * @return ?Dating
     */
    public function getDatingByUserAndDatingDay(User $user, DatingDay $datingDay): ?Dating;

    /**
     * Check user has completed dating
     * @param User $user
     * @return bool
     */
    public function hasCompletedDating(User $user): bool;

    /**
     * @param array $userIds
     * @param Carbon $from
     * @param Carbon $to
     * @param int $status
     * @return Collection
     */
    public function getDatingsByUserIdsOnDates(array $userIds, Carbon $from, Carbon $to, int $status): Collection;

    /**
     * @param DatingDay $datingDay
     * @param array|null $userIds
     * @return Collection
     */
    public function getDatingUsersForDatingDay(DatingDay $datingDay, ?array $userIds = null): Collection;

    /**
     * @param array $userIds
     * @return Collection
     */
    public function getLatestDatingUsersByUserIds(array $userIds, ?array $with = null): Collection;
}
