<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\DatingDay\Repository;

use Bachelor\Domain\DatingManagement\DatingDay\Interfaces\DatingDayRepositoryInterface;
use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\DatingManagement\DatingDay\ModelDao\DatingDay as ModelDAO;
use Bachelor\Utility\Enums\Status;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EloquentDatingDayRepository extends EloquentBaseRepository implements DatingDayRepositoryInterface
{
    /**
     * EloquentMatchingDateRepository constructor.
     * @param ModelDAO $modelDao
     */
    public function __construct(ModelDAO $modelDao)
    {
        parent::__construct($modelDao);
    }

    /**
     * @param int $id
     * @return DatingDay|null
     */
    public function getById(int $id): ?DatingDay
    {
        $modelDao = $this->createQuery()->where('id', $id)->first();

        return $modelDao ? $modelDao->toDomainEntity() : null;
    }

    /**
     * @param array $ids
     * @return Collection
     */
    public function getByIds(array $ids): Collection
    {
        return $this->transformCollection($this->createQuery()->whereIn($this->modelDAO->getKeyName(), $ids)->get());
    }

    /**
     * @param DatingDay $model
     * @return DatingDay
     */
    public function save(DatingDay $model): DatingDay
    {
        return $this->createModelDAO($model->getId())->saveData($model);
    }

    /**
     * Get all valid dating dates
     *
     * @param string $fromDate Format: 'Y-m-d'
     * @param string $toDate Format: 'Y-m-d'
     * @return DatingDay[] | Collection
     */
    public function getRange(string $fromDate, string $toDate = ''): Collection
    {
        $filter = $this->createQuery();
        if (!empty($fromDate)) {
            $filter = $filter->where('dating_date', '>=', $fromDate);
        }
        if (!empty($toDate)) {
            $filter = $filter->where('dating_date', '<=', $toDate);
        }
        $filter = $filter->orderBy('dating_date');
        return $this->transformCollection($filter->get());
    }

    /**
     * get latest record
     *
     * @return NULL|DatingDay
     */
    public function getLatestDatingDay(): ?DatingDay
    {
        $modelDao = $this->createQuery()->orderBy("dating_date", "desc")->first();
        return $modelDao?->toDomainEntity();
    }

    /**
     * Returns latest dating day object based on day and date
     *
     * @param string $date
     * @param string $dayOfWeek
     * @return NULL
     */
    public function getLatestDayOnDayOfWeekAfter(string $date, string $dayOfWeek)
    {
        $modelDao = $this->createQuery()->where('dating_date', '>=', $date)->where('dating_day', $dayOfWeek)->first();

        return $modelDao ? $modelDao->toDomainEntity() : null;
    }

    /**
     * @param string $date
     * @return DatingDay|null
     */
    public function getByDate(string $date): ?DatingDay
    {
        $modelDao = $this->createQuery()
            ->where('dating_date', '>=', $date)
            ->where('dating_date', '<=', $date)
            ->first();

        return $modelDao?->toDomainEntity();
    }

    /**
     * Get all valid dating dates by day
     *
     * @param string $dayOfWeek
     * @return DatingDay|Null
     */
    public function getNextDatingDayByDayOfWeek(string $dayOfWeek): ?DatingDay
    {
        $now = Carbon::now()->toDateString();
        $modelDao = $this->createQuery()->where('dating_date', '>=', $now)
        ->where('dating_day', $dayOfWeek)
        ->orderBy('dating_date', 'ASC')
        ->first();
        return $modelDao?->toDomainEntity();
    }

    public function getDatingDays($limit): Collection
    {
        $query = $this->createQuery();
        $query = $query->orderBy('id', 'DESC')->limit($limit);

        return $this->transformCollection($query->get());
    }
}
