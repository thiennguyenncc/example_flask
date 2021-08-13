<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\UserTrial\Repository;

use Bachelor\Domain\PaymentManagement\UserTrial\Enum\TrialStatus;
use Bachelor\Domain\PaymentManagement\UserTrial\Interfaces\UserTrialRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Models\UserTrial;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\PaymentManagement\UserTrial\ModelDao\UserTrial as UserTrialDao;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EloquentUserTrialRepository extends EloquentBaseRepository implements UserTrialRepositoryInterface
{
    /**
     * EloquentUserTrialRepository constructor.
     * @param UserTrialDao $userTrialDao
     */
    public function __construct(UserTrialDao $userTrialDao)
    {
        parent::__construct($userTrialDao);
    }

    /**
     * Get user trial
     *
     * @param User $user
     * @return UserTrial|null
     */
    public function getLatestTrialByUser(User $user): ?UserTrial
    {
        $trial = $this->modelDAO
            ->where('user_id', $user->getId())
            ->latest()
            ->first();

        return $trial ? $trial->toDomainEntity() : null;
    }

    /**
     * get UserTrial Collection By EndDate
     *
     * @return Collection
     */
    public function getFinishedActiveUserTrialCollection(): Collection
    {
        $trial = $this->modelDAO
            ->where('trial_end', '<', Carbon::now())
            ->where('status', TrialStatus::Active)
            ->get();

        return $this->transformCollection($trial);
    }

    /**
     * get All UserTrial Collection By Status
     *
     * @return Collection
     */
    public function getAllLatestUserTrialByStatus(int $status): Collection
    {
        $builder = $this->modelDAO->newModelQuery()
            ->whereIn('id', function ($query) {
                $query->select(DB::raw('MAX(id) As id'))
                    ->from('user_trials')->groupBy('user_id');
            })
            ->where('status', $status);

        return $this->transformCollection($builder->get());
    }

    /**
     * Save user trial
     *
     * @param UserTrial $userTrial
     * @return mixed
     */
    public function save(UserTrial $userTrial): UserTrial
    {
        return $this->createModelDAO($userTrial->getId())->saveData($userTrial);
    }

    /**
     * @param User $user
     * @param int $status
     * @return Collection
     */
    public function getUserTrialsByUser(User $user, int $status): Collection
    {
        $trials = $this->modelDAO
            ->where('trial_start', '<', Carbon::now())
            ->where('trial_end', '>', Carbon::now())
            ->where('status', TrialStatus::Active)
            ->get();

        return $this->transformCollection($trials);
    }

    /**
     * Get user trial
     *
     * @param User $user
     * @return UserTrial|null
     */
    public function getLatestUserTrialByUserIfActive(User $user): ?UserTrial
    {
        $trial = $this->modelDAO->getSpecificData($user->getId(), 'user_id')->latest()->first();

        return $trial?->status == TrialStatus::Active ? $trial->toDomainEntity() : null;
    }

    /**
     * @param array $userIds
     * @return Collection
     */
    public function getByUserIds(array $userIds): Collection
    {
        $query = $this->createQuery()->whereIn('user_id', $userIds);

        return $this->transformCollection($query->get());
    }
}
