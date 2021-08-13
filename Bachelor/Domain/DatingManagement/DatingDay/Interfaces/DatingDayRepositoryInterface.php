<?php

namespace Bachelor\Domain\DatingManagement\DatingDay\Interfaces;

use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Illuminate\Support\Collection;

interface DatingDayRepositoryInterface
{
    /**
     * @param int $id
     * @return DatingDay|null
     */
    public function getById(int $id): ?DatingDay;

    /**
     * @param array $ids
     * @return Collection|DatingDay[]
     */
    public function getByIds(array $ids): Collection;

    /**
     * @param string $fromDate Format: 'Y-m-d'
     * @param string $toDate Format: 'Y-m-d'
     * @return Collection
     */
    public function getRange(string $fromDate, string $toDate = ''): Collection;

    /**
     * @param DatingDay $model
     * @return DatingDay
     */
    public function save(DatingDay $model): DatingDay;

    /**
     * get latest record
     * @return NULL|DatingDay
     */
    public function getLatestDatingDay(): ?DatingDay;

    /**
     * Returns latest dating day object based on day and date
     *
     * @param string $date
     * @param string $dayOfWeek
     * @return NULL
     */
    public function getLatestDayOnDayOfWeekAfter(string $date, string $dayOfWeek);

    /**
     * @param string $date
     * @return DatingDay|null
     */
    public function getByDate(string $date): ?DatingDay;

    /**
     * Get all valid dating dates by day
     *
     * @param string $dayOfWeek
     * @return DatingDay|null
     */
    public function getNextDatingDayByDayOfWeek(string $dayOfWeek): ?DatingDay;

    /**
     * @param $limit
     * @return Collection
     */
    public function getDatingDays($limit): Collection;
}
