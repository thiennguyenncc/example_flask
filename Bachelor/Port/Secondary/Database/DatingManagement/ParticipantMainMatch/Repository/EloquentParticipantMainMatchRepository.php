<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\ParticipantMainMatch\Repository;

use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantsStatus;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Model\ParticipantMainMatch;
use Bachelor\Domain\UserManagement\User\Enums\IsFake;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantMainMatch\ModelDao\ParticipantMainMatch as ModelDao;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EloquentParticipantMainMatchRepository extends EloquentBaseRepository implements ParticipantMainMatchRepositoryInterface
{
    /**
     * EloquentParticipantRepository constructor.
     * @param ModelDao $modelDao
     */
    public function __construct(ModelDao $modelDao)
    {
        parent::__construct($modelDao);
    }

    /**
     * @param int $prefectureId
     * @param int $datingDayId
     * @return array
     */
    public function getCountPerGenderByPrefectureAndDatingDay(int $prefectureId, int $datingDayId, ?array $statuses = null): Collection
    {
        $query = $this->model
            ->join('users', 'participants_main_matching.user_id', '=', 'users.id')
            ->select('users.gender as gender', DB::raw("count(participants_main_matching.id) as count"))
            ->where('dating_day_id', $datingDayId)
            ->where('users.prefecture_id', $prefectureId);

        if ($statuses) {
            $query = $query->whereIn('participants_main_matching.status', $statuses);
        }

        return $query->groupBy('users.gender')->get();
    }


    /**
     * @param int $prefectureId
     * @param int $datingDayId
     * @param array|null $statuses
     * @param array|null $with
     * @return Collection
     */
    public function getParticipantMainMatchByPrefectureAndDatingDay(int $prefectureId, int $datingDayId, ?array $statuses, ?array $with = null): Collection
    {
        $query = $this->createQuery()
            ->where('dating_day_id', $datingDayId)
            ->whereHas('user', function ($q) use ($prefectureId) {
                $q->where('prefecture_id', $prefectureId);
            });
        if ($statuses) {
            $query = $query->whereIn('status', $statuses);
        }
        if ($with != null) {
            $query = $query->with($with);
        }
        return $this->transformCollection($query->get());
    }

    /**
     * @return Paginator
     */
    public function listAwaitingParticipantsWithPaginator(): Paginator
    {
        return $this->createQuery()
            ->select(['id', 'user_id', 'dating_day_id'])
            ->with(['user:id,name,gender', 'datingDay:id,dating_day,dating_date'])
            ->simplePaginate($this->modelDAO->getPerPage());
    }

    /**
     * Get all sample participants for one user
     *
     * @param User $user
     * @return Collection | ParticipantMainMatch[]
     */
    public function getAwaitingForUser(User $user): Collection
    {
        $collection = $this->createQuery()
            ->where('user_id', $user->getId())
            ->where('status', ParticipantsStatus::Awaiting)
            ->with('datingDay')
            ->get();

        return $this->transformCollection($collection);
    }

    /**
     * @return Collection | ParticipantMainMatch[]
     */
    public function getAllNotCompletedRegistrationByStatus(int $status): ?Collection
    {
        $collection = $this->createQuery()
            ->where('status', $status)
            ->with(['datingDay', 'user', 'user.userInfoUpdatedTime'])
            ->get();

        $entities = $this->transformCollection($collection);

        return $entities->filter(function ($participant) {
            return $participant->getUser()->getRegistrationCompleted() == false;
        });
    }

    /**
     * @param Collection $users
     * @return Collection
     */
    public function getParticipantsByUserIds(array $userIds, ?array $statuses = null, ?array $relations = null): Collection
    {
        $query = $this->createQuery()
            ->with('datingDay')
            ->whereIn('user_id', $userIds);

        if ($statuses) {
            $query->whereIn('status', $statuses);
        }

        if ($relations) {
            $query = $query->with($relations);
        }

        return $this->transformCollection($query->get());
    }

    /**
     * @param User $user
     * @return Collection | ParticipantMainMatch[]
     */
    public function getParticipantsHaveSampleDateForUser(User $user): Collection
    {
        $collection = $this->createQuery()
            ->where('user_id', $user->getId())
            ->where('show_sample_date', true)
            ->with('datingDay')->get();

        return $this->transformCollection($collection);
    }

    /**
     * @param User $user
     * @param DatingDay $datingDay
     * @return ParticipantMainMatch|null
     */
    public function getAwaitingByUserAndDate(User $user, DatingDay $datingDay, ?array $relations = null): ?ParticipantMainMatch
    {
        /* @var ModelDao $participant */
        $participant = $this->createQuery()
            ->where('user_id', $user->getId())
            ->where('dating_day_id', $datingDay->getId())
            ->where('status', ParticipantsStatus::Awaiting);

        if ($relations) {
            $participant = $participant->with($relations);
        }
        $participant = $participant->first();

        return $participant ? $participant->toDomainEntity() : null;
    }

    /**
     * @param Collection | User[] $users
     * @param Carbon $dayInWeek
     * @return Collection | ParticipantMainMatch[]
     */
    public function getAwaitingForUsersInSameWeek(Collection|array $users, Carbon $dayInWeek): Collection
    {
        $userIds = [];
        foreach ($users as $user) {
            $userIds[] = $user->getId();
        }
        $query = $this->createQuery()
            ->with('datingDay')
            ->whereIn('user_id', $userIds)
            ->where('status', ParticipantsStatus::Awaiting)
            ->whereHas('datingDay', function ($q) use ($dayInWeek) {
                $q->where('dating_date', '>=', $dayInWeek->startOfWeek()->toDateString());
                $q->where('dating_date', '<=', $dayInWeek->endOfWeek()->toDateString());
            });
        return $this->transformCollection($query->get());
    }

    /**
     * @param User $user
     * @param string $from format Y-m-d
     * @return Collection | ParticipantMainMatch[]
     */
    public function getParticipatedHistoryForUser(User $user, string $from = ''): Collection
    {
        $query = $this->createQuery()
            ->with('datingDay')
            ->where('user_id', $user->getId())
            ->where('status', '<>', ParticipantsStatus::Cancelled);

        if ($from) {
            $query->whereHas('datingDay', function ($q) use ($from) {
                $q->where('dating_date', '>=', $from);
            });
        }
        return $this->transformCollection($query->get());
    }

    /**
     * @param User $user
     * @param Carbon $dayInWeek
     * @return Collection
     */
    public function getParticipatedHistoryForUserInSameWeek(User $user, Carbon $dayInWeek): Collection
    {
        $query = $this->createQuery()
            ->with('datingDay')
            ->where('user_id', $user->getId())
            ->where('status', '<>', ParticipantsStatus::Cancelled)
            ->whereHas('datingDay', function ($q) use ($dayInWeek) {
                $q->where('dating_date', '>=', $dayInWeek->startOfWeek()->toDateString());
                $q->where('dating_date', '<=', $dayInWeek->endOfWeek()->toDateString());
            });
        return $this->transformCollection($query->get());
    }

    /**
     * @param [] $userIds
     * @param Carbon $dayInWeek
     * @return Collection | ParticipantMainMatch[]
     */
    public function getParticipatedHistoryForUsersInSameWeek(array $userIds, Carbon $dayInWeek): Collection
    {
        $query = $this->createQuery()
            ->with('datingDay')
            ->whereIn('user_id', $userIds)
            ->where('status', '<>', ParticipantsStatus::Cancelled)
            ->whereHas('datingDay', function ($q) use ($dayInWeek) {
                $q->where('dating_date', '>=', $dayInWeek->startOfWeek()->toDateString());
                $q->where('dating_date', '<=', $dayInWeek->endOfWeek()->toDateString());
            });
        return $this->transformCollection($query->get());
    }

    /**
     * @param ParticipantMainMatch $participantMainMatch
     * @return ParticipantMainMatch
     */
    public function save(ParticipantMainMatch $participantMainMatch): ParticipantMainMatch
    {
        return $this->createModelDAO($participantMainMatch->getId())->saveData($participantMainMatch);
    }

    /**
     * Reset last weeks
     *
     * @param int $weekOffset
     * @return bool
     * @throws \Exception
     */
    public function removeParticipantsInWeek(int $weekOffset = 0): bool
    {
        $startWeekDate = Carbon::now()->subWeeks($weekOffset)->startOfWeek(Carbon::MONDAY)->toDateString();
        $endWeekDate = Carbon::now()->subWeeks($weekOffset)->endOfWeek(Carbon::SUNDAY)->toDateString();

        $this->createQuery()
            ->whereHas('datingDay', function ($query) use ($startWeekDate, $endWeekDate) {
                return $query->where('dating_date', '<=', $endWeekDate)
                    ->where('dating_date', '>=', $startWeekDate);
            })->delete();

        return true;
    }

    /**
     * Import participants
     *
     * @param array $formattedImportData
     * @return array
     */
    public function importParticipants(array $formattedImportData): array
    {
        $data = ['success' => [], 'failure' => []];
        foreach ($formattedImportData as $row) {
            $dateIds = array_map(function ($date) {
                return $date['id'];
            }, $row['dating_dates']);

            if ($this->importParticipant($row['user_id'], $dateIds)) {
                $data['success'][] = $row;
            } else {
                $data['failure'][] = $row;
            }
        }
        return $data;
    }

    /**
     * @param int $userId
     * @param int[] $datingDateIds
     * @return bool
     */
    private function importParticipant(int $userId, array $datingDateIds): bool
    {
        try {
            DB::beginTransaction();
            foreach ($datingDateIds as $dateId) {
                $participant = $this->firstOrCreate([
                    'user_id' => $userId,
                    'dating_day_id' => $dateId
                ]);
                $participant->status = ParticipantsStatus::Awaiting;
                $participant->save();
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * @param User $user
     * @param DatingDay $datingDay
     * @return ParticipantMainMatch|null
     */

    public function getLatestByUserAndDay(User $user, DatingDay $datingDay): ?ParticipantMainMatch
    {
        /* @var ModelDao $participant */
        $participant = $this->createQuery()
            ->where('user_id', $user->getId())
            ->where('dating_day_id', $datingDay->getId())
            ->first();

        return optional($participant)->toDomainEntity();
    }

    /**
     * @param Carbon $datingDate
     * @param int $status
     * @return Collection
     */
    public function getParticipantsByStatusAndDate(int $status, Carbon $datingDate): Collection
    {
        $query = $this->createQuery()
            ->where('status', $status)
            ->whereHas('datingDay', function ($q) use ($datingDate) {
                $q->where('dating_date', $datingDate->toDateString());
            });

        return $this->transformCollection($query->get());
    }

    /**
     * @param int $status
     * @param Carbon $dayInWeek
     * @return Collection
     */
    public function getParticipantsForFakeUserByStatusAndDate(int $status, Carbon $dayInWeek): Collection
    {
        $query = $this->createQuery()
            ->where('status', $status)
            ->whereHas('datingDay', function ($q) use ($dayInWeek) {
                $q->where('dating_date', '>=', $dayInWeek->startOfWeek()->toDateString());
                $q->where('dating_date', '<=', $dayInWeek->endOfWeek()->toDateString());
            })
            ->whereHas('user', function ($q) {
                $q->where('is_fake', IsFake::FakeUser);
            });

        return $this->transformCollection($query->get());
    }
}
