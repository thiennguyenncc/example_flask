<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\ParticipationOpenExpirySetting\Repository;

use Bachelor\Domain\DatingManagement\ParticipationOpenExpirySetting\Interfaces\ParticipationOpenExpirySettingRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipationOpenExpirySetting\Model\ParticipationOpenExpirySetting;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipationOpenExpirySetting\ModelDao\ParticipationOpenExpirySetting as ModelDao;
use Illuminate\Support\Collection;

class EloquentParticipationOpenExpirySettingRepository extends EloquentBaseRepository implements ParticipationOpenExpirySettingRepositoryInterface
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
     * get participation open/expiry setting data
     *
     * @param array $filter is array have list param like user_gender or some other key for filter data
     *
     * @return ParticipationOpenExpirySetting[]|Collection
     */
    public function getRange(array $filter): Collection
    {
        $query = $this->createQuery()
            ->where('user_gender', $filter['user_gender']);

        return $this->transformCollection($query->get());
    }

    /**
     * get participation open/expiry setting detail by param
     *
     * @param int $gender
     * @param string $day
     * @param int $is2ndFormCompleted
     * @return ParticipationOpenExpirySetting|null
     */
    public function getDetail(int $gender, string $day, int $is2ndFormCompleted): ?ParticipationOpenExpirySetting
    {
        $modelDao = $this->createQuery()->where('user_gender', $gender)
            ->where('dating_day_of_week', $day)
            ->where('is_user_2nd_form_completed', $is2ndFormCompleted)->first();
        return $modelDao ? $modelDao->toDomainEntity() : null;
    }

    /**
     * create or update participation open closed expired setting data
     *
     ** @param ParticipationOpenExpirySetting $model
     * @return ParticipationOpenExpirySetting
     */
    public function save(ParticipationOpenExpirySetting $model): ParticipationOpenExpirySetting
    {
        return $this->createModelDAO($model->getId())->saveData($model);
    }
}
