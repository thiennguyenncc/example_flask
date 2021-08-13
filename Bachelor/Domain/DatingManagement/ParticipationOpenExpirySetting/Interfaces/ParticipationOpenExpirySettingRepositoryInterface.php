<?php

namespace Bachelor\Domain\DatingManagement\ParticipationOpenExpirySetting\Interfaces;

use Bachelor\Domain\DatingManagement\ParticipationOpenExpirySetting\Model\ParticipationOpenExpirySetting;
use Illuminate\Support\Collection;

interface ParticipationOpenExpirySettingRepositoryInterface
{
    /**
     * get participation open/expiry setting data
     *
     * @param array $filter is array have list param like user_gender or some other key for filter data
     *
     * @return Collection
     */
    public function getRange(array $filter): Collection;
    /**
     * get participation open/expiry setting detail by param
     *
     * @param int $gender
     * @param string $day
     * @param int $is2ndFormCompleted
     * @return ParticipationOpenExpirySetting|null
     */
    public function getDetail(int $gender, string $day, int $is2ndFormCompleted): ?ParticipationOpenExpirySetting;

    /**
     * create or update participation open closed expired setting data
     *
     ** @param ParticipationOpenExpirySetting $model
     * @return bool
     */
    public function save(ParticipationOpenExpirySetting $model): ParticipationOpenExpirySetting;
}
