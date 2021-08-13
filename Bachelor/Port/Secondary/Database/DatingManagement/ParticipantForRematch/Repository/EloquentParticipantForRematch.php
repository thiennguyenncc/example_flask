<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\ParticipantForRematch\Repository;

use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Enums\ParticipantForRematchStatus;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Models\ParticipantForRematch;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantsStatus;
use Bachelor\Domain\PaymentManagement\UserTrial\Enum\TrialStatus;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantForRematch\ModelDao\ParticipantForRematch as ModelDAO;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Interfaces\ParticipantForRematchRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class EloquentParticipantForRematch extends EloquentBaseRepository implements ParticipantForRematchRepositoryInterface
{

    /**
     * EloquentMatchingDateRepository constructor.
     *
     * @param ModelDAO $modelDao
     */
    public function __construct(ModelDAO $modelDao)
    {
        parent::__construct($modelDao);
    }

    /**
     * Save Record
     *
     * @param ParticipantForRematch $participantForRematch
     * @return ParticipantForRematch|null
     */
    public function save(ParticipantForRematch $participantForRematch): ?ParticipantForRematch
    {
        return $this->createModelDAO($participantForRematch->getId())->saveData($participantForRematch);
    }

    /**
     * Gets user rematching participation
     *
     * @param User $user
     * @param DatingDay $datingDay
     * @return NULL
     */
    public function getByUserAndDatingDay(User $user, DatingDay $datingDay): ?ParticipantForRematch
    {
        $modelDao = $this->createQuery()
            ->where([
                'user_id' => $user->getId(),
                'dating_day_id' => $datingDay->getId()
            ])
            ->first();

        return $modelDao ? $modelDao->toDomainEntity() : null;
    }

    /**
     * Get all awaiting participation requests for one user
     *
     * @param User $user
     * @return Collection
     */
    public function getAwaitingForUser(User $user): Collection
    {
        $collection = $this->createQuery()
            ->where('user_id', $user->getId())
            ->where('status', ParticipantForRematchStatus::Awaiting)
            ->with('datingDay')
            ->get();

        return $this->transformCollection($collection);
    }

    /**
     * @param int $status
     * @param Carbon $dayInWeek
     * @param bool $isForTrialUser
     * @param int|null $gender
     * @return Collection
     */
    public function getParticipantsRematchingByStatusAndDate(int $status, Carbon $dayInWeek, bool $isForTrialUser = false, ?int $gender = null): Collection
    {
        if ($isForTrialUser) {
            $query = $this->createQuery()
                ->whereHas('user', function ($q) use($gender) {
                    if ($gender != null) {
                        $q->where('gender', $gender);
                    }
                    $q->whereHas('userTrial', function ($q) {
                        $q->where('trial_start', '<', now()->format('Y-m-d H:i:s'))
                            ->where('trial_end', '>', now()->format('Y-m-d H:i:s'))
                            ->where('status', TrialStatus::Active);
                    });
                })
                ->where('status', $status);

            return $this->transformCollection($query->get());
        }

        $query = $this->createQuery()
            ->where('status', $status)
            ->whereHas('datingDay', function ($q) use ($dayInWeek) {
                $q->where('dating_date', '>=', $dayInWeek->startOfWeek()->toDateString());
                $q->where('dating_date', '<=', $dayInWeek->endOfWeek()->toDateString());
            });

        return $this->transformCollection($query->get());
    }

    /**
     * Reset last weeks
     *
     * @param int $weekOffset
     * @return bool
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
}
