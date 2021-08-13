<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\Dating\Repository;

use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Domain\DatingManagement\Dating\Enums\DatingUserProperty;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Bachelor\Domain\DatingManagement\Dating\Models\Dating;
use Bachelor\Domain\DatingManagement\Dating\Models\DatingUser;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\Dating as DatingDAO;
use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\DatingUser as DatingUserDAO;
use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\DatingUserCancellForm as DatingUserCancellFormDAO;
use Illuminate\Support\Facades\DB;

class DatingRepository extends EloquentBaseRepository implements DatingRepositoryInterface
{

    /**
     *
     * @var DatingUserDAO
     */
    protected DatingUserDAO $datingUserDAO;

    /**
     *
     * @var DatingUserCancellFormDAO
     */
    protected DatingUserCancellFormDAO $datingUserCancellFormDAO;

    /**
     * DatingRepository constructor.
     *
     * @param DatingDAO $datingDAO
     */
    public function __construct(DatingDAO $datingDAO)
    {
        $this->datingUserDAO = new DatingUserDAO();
        parent::__construct($datingDAO);
    }

    /**
     * get Dating by Id
     *
     * @param integer $datingId
     * @param integer|null $status
     * @param array|null $with
     * @return Dating
     */
    public function getDatingById(int $datingId, ?int $status = null, ?array $with = null): Dating
    {
        $query = $this->createQuery();
        if ($status != null) {
            $query = $query->where('status', $status);
        }
        if ($with != null) {
            if (in_array(DatingUserProperty::User, $with)) {
                $query = $query->with("datingUsers.user");
            }
        }
        $dating = $query->findOrFail($datingId);
        if ($dating) {
            return $dating->toDomainEntity();
        }
        throw new Exception(__('api_messages.dating.no_dating_found'));
    }

    /**
     *
     * @param integer $userId
     * @return Dating|null
     */
    public function getLatestDatingByUserId(int $userId, ?int $status = null, ?int $partnerId = null): ?Dating
    {
        $builder = $this->model->select('dating.*')
            ->join('dating_days', 'dating_days.id', '=', 'dating.dating_day_id')
            ->whereHas('datingUsers', function ($builder) use ($userId) {
                return $builder->where('user_id', $userId);
            });

        if ($partnerId) {
            $builder = $builder->whereHas('datingUsers', function ($builder) use ($partnerId) {
                return $builder->where('user_id', $partnerId);
            });
        }

        if ($status) {
            $builder = $builder->where('status', $status);
        }

        $datingDao = $builder->orderBy('dating_days.dating_date', 'DESC')->first();

        return $datingDao?->toDomainEntity();
    }

    /**
     * Get datings
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
    public function getDatingsFromTo(?Carbon $from = null, ?Carbon $to = null, ?int $status = null, ?array $with = null, ?string $search = "", ?int $isFake = null, ?string $datingDate = null, ?string $startTime = null): Collection
    {
        $builder = $this->createQuery();
        if ($with) {
            $builder = $builder->with($with);
        }
        if ($status !== null) {
            $builder = $builder->where('dating.status', $status);
        }
        if ($search !== '' && $search !== null){
            $builder = $builder->where(function ($builderQuery) use ($search) {
                return $builderQuery->where('id', $search)
                    ->orWhereHas('datingUsers.user', function ($q) use ($search){
                        $q->where('id', $search)->orWhere('name', 'like', '%'.$search.'%');
                    })
                    ->orWhereHas('datingPlace.area.areaTranslation', function ($q) use ($search){
                        $q->where('name', 'like', '%'.$search.'%');
                    })
                    ->orWhereHas('datingPlace.datingPlaceTranslation', function ($q) use ($search) {
                        $q->where('name', 'like', '%'.$search.'%');
                    });
            });
        }
        if ($datingDate !== null || $from != null || $to != null){
            $builder = $builder->whereHas('datingDay', function ($query) use ($from, $to, $datingDate) {
                if ($datingDate == null){
                    if ($from) {
                        $query->where('dating_date', '>=', $from->toDateTimeString());
                    }
                    if ($to) {
                        $query->where('dating_date', '<=', $to->toDateTimeString());
                    }
                }else {
                    $query->where('dating_date', $datingDate);
                }
            });
        }
        if ($isFake !== null){
            $builder = $builder->whereHas( 'datingUsers.user', function ($q) use ($isFake){
               $q->where('gender', UserGender::Female)->where('is_fake', $isFake);
            });
        }
        if ($startTime !== null){
            $builder = $builder->where('start_at', $startTime);
        }
        return $this->transformCollection($builder->get());
    }

    /**
     * Get datings by user id
     *
     * @param int $userId
     * @param int|null $status
     * @param int|null $datingDayId
     * @return Collection
     */
    public function getDatingsByUserId(int $userId, ?int $status = null, ?int $datingDayId = null): Collection
    {
        $builder = $this->model->whereHas('datingUsers', function ($builder) use ($userId) {
            return $builder->where('user_id', $userId);
        });

        if ($status) {
            $builder = $builder->where('status', $status);
        }

        if ($datingDayId) {
            $builder = $builder->where('dating_day_id', $datingDayId);
        }

        return $this->transformCollection($builder->get());
    }

    /**
     * get not completed Dating
     *
     * @param User $user
     * @return Dating
     */
    public function getNotCompletedDatings(User $user): Collection
    {
        $datings = $this->model
            ->where('status', '<>', DatingStatus::Completed)
            ->whereHas('datingUsers', function ($builder) use ($user) {
                return $builder->where('user_id', $user->getId());
            })
            ->orderBy('created_at');

        return $this->transformCollection($datings->get());
    }

    /**
     * Get datings no feedback by user id
     *
     * @param int $userId
     * @param int|null $status
     * @return Collection
     */
    public function getDatingsNoFeedbackByUserId(
        int $userId,
        ?int $status = null,
        ?Carbon $datingDayFrom = null,
        ?Carbon $datingDayTo = null,
        ?array $with = null
    ): Collection {
        $builder = $this->model->newModelQuery()->whereHas('datingUsers', function ($query) use ($userId) {
            return $query->where('user_id', $userId);
        })
            ->whereDoesntHave('feedbacks', function ($query) use ($userId) {
                return $query->where('feedback_by', $userId);
            });

        if ($status) {
            $builder = $builder->where('status', $status);
        }

        if ($datingDayFrom) {
            $builder = $builder->whereHas('datingDay', function ($query) use ($datingDayFrom) {
                return $query->where('dating_date', '>=', $datingDayFrom);
            });
        }

        if ($datingDayTo) {
            $builder = $builder->whereHas('datingDay', function ($query) use ($datingDayTo) {
                return $query->where('dating_date', '<=', $datingDayTo);
            });
        }

        if ($with) {
            $builder = $builder->with($with);
        }

        return $this->transformCollection($builder->get());
    }

    /**
     * Remove all Imcomplete Dating
     *
     * @param int $weekOffset
     * @return bool
     */
    public function deleteDatingsInWeek(int $weekOffset = 0): bool
    {
        $startWeekDate = Carbon::now()->subWeeks($weekOffset)->startOfWeek(Carbon::MONDAY)->toDateString();
        $endWeekDate = Carbon::now()->subWeeks($weekOffset)->endOfWeek(Carbon::SUNDAY)->toDateString();

        $query = $this->model->whereHas('datingDay', function ($query) use ($startWeekDate, $endWeekDate) {
            return $query->where('dating_date', '<=', $endWeekDate)
                ->where('dating_date', '>=', $startWeekDate);
        });
        return (bool)$query->delete();
    }

    /**
     * save Dating with DatingUser and DatingUserCancelForm
     *
     * @param Dating $dating
     * @return Dating
     */
    public function save(Dating $dating): Dating
    {
        $dating = $this->createModelDAO($dating->getId())->saveData($dating);
        $dating->getDatingUsers()->each(function (DatingUser $datingUser) use ($dating) {

            $datingUser->setDatingId($dating->getId());
            $datingUserDAO = new DatingUserDAO();
            $datingUserDAO->saveData($datingUser);
            if ($datingUserCancellForm = $datingUser->getDatingUserCancellForm()) {
                $datingUserCancellForm->setDatingUserId($datingUser->getId());
                $datingUserCancellFormDAO = new DatingUserCancellFormDAO();
                $datingUserCancellFormDAO->saveData($datingUserCancellForm);
            }
            return true;
        });

        return $dating;
    }

    /**
     * @param Carbon $from
     * @param Carbon $to
     * @param int $status
     * @return Collection
     */
    public function getDatingsHasFeedbacksFromTo(Carbon $from, Carbon $to, int $status): Collection
    {
        $datings = $this->model->newModelQuery()->with(['datingUsers', 'feedbacks'])
            ->whereHas('datingUsers')
            ->whereHas('feedbacks')
            ->whereHas('datingDay', function ($q) use ($from, $to) {
                $q->whereBetween('dating_date', [$from, $to]);
            })
            ->where('status', $status)
            ->get();

        return $this->transformCollection($datings);
    }

    public function getDatingsByUserIdsOnDates(array $userIds, Carbon $from, Carbon $to, int $status): Collection
    {
        $datings = $this->model->newModelQuery()
            ->whereHas('datingDay', function ($q) use ($from, $to) {
                $q->whereBetween('dating_date', [$from, $to]);
            })->whereHas('datingUsers', function ($q) use ($userIds) {
                $q->whereIn('user_id', $userIds);
            })->where('status', $status)
            ->get();

        return $this->transformCollection($datings);
    }

    /**
     * @param User $user
     * @param DatingDay $datingDay
     * @return ?Dating
     */
    public function getDatingByUserAndDatingDay(User $user, DatingDay $datingDay): ?Dating
    {
        $builder = $this->createQuery()->whereHas('datingUsers', function ($query) use ($user, $datingDay) {
            return $query->where('user_id', $user->getId());
        })->where(['dating_day_id' => $datingDay->getId(),]);
        $builder = $builder->with("datingUsers.user");
        $datingDay = $builder->orderBy('id', 'desc')->first();

        return $datingDay ? $datingDay->toDomainEntity() : null;
    }

    /**
     * Check user has completed dating
     * @param User $user
     * @return bool
     */
    public function hasCompletedDating(User $user): bool
    {
        $builder = $this->model->newModelQuery()->whereHas('datingUsers', function ($query) use ($user) {
            return $query->where('user_id', $user->getId());
        })
            ->where([
                'status' => DatingStatus::Completed
            ])->first();
        return $builder != null ? true : false;
    }

    /**
     * Get incompeted datings by dating day id
     *
     * @param int $datingDayId
     * @return Collection
     */
    public function getIncompletedDatingsByDatingDay(int $datingDayId): Collection
    {
        $datings = $this->model
            ->where('status', DatingStatus::Incompleted)
            ->where('dating_day_id', $datingDayId);

        return $this->transformCollection($datings->get());
    }


    /**
     * @return Collection
     */
    public function getDatingsCompletedToday(): Collection
    {
        $today = Carbon::now();

        $datings = $this->model
            ->where('status', DatingStatus::Completed)
            ->whereHas('datingDay', function ($q) use ($today) {
                $q->where('dating_date', $today->toDateString());
            });

        $datings = $datings->with("datingUsers.user");

        return $this->transformCollection($datings->get());
    }

    /**
     * Get completed datings without feedback
     *
     * @param Carbon|null $from
     * @param Carbon|null $to
     * @return Collection
     */
    public function getCompletedDatingWithoutFeedback(?Carbon $from = null, ?Carbon $to = null): Collection
    {
        $builder = $this->model
            ->where('status', DatingStatus::Completed)
            ->whereHas('datingDay', function ($query) use ($from, $to) {
                if ($from) {
                    $query->where('dating_date', '>=', $from->toDateTimeString());
                }
                if ($to) {
                    $query->where('dating_date', '<=', $to->toDateTimeString());
                }
            })
            ->doesntHave('feedbacks');

        $builder = $builder->with("datingUsers.user");

        return $this->transformCollection($builder->get());
    }


    /**
     * @param DatingDay $datingDay
     * @param array|null $userIds
     * @return Collection
     */
    public function getDatingUsersForDatingDay(DatingDay $datingDay, ?array $userIds = null): Collection
    {
        $collection = $this->datingUserDAO->newModelQuery()
            ->whereHas('dating', function ($query) use ($datingDay) {
                return $query->where(['dating_day_id' => $datingDay->getId()]);
            })->with(['dating','user']);
            if($userIds != null){
                $collection = $collection->whereIn('user_id', $userIds);
            }
        $collection = $collection->get();
        return $this->transformCollection($collection);
    }

    /**
     * @return Collection
     */
    public function getLatestDatingUsersByUserIds(array $userIds, ?array $with = null): Collection
    {
        $builder = $this->datingUserDAO->newModelQuery()
            ->whereIn('id', function ($query) {
                $query->select(DB::raw('MAX(id) As id'))
                    ->from('dating_users')->groupBy('user_id');
            })
            ->whereIn('user_id', $userIds);

        if ($with) {
            $builder->with($with);
        }

        return $this->transformCollection($builder->get());
    }
}
