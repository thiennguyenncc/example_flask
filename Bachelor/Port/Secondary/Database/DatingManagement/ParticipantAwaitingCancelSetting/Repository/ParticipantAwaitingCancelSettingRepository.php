<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\ParticipantAwaitingCancelSetting\Repository;

use Bachelor\Domain\DatingManagement\ParticipantAwaitingCancelSetting\Interfaces\ParticipantAwaitingCancelSettingRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantAwaitingCancelSetting\Models\ParticipantAwaitingCancelSetting;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantAwaitingCancelSetting\ModelDao\ParticipantAwaitingCancelSetting as ModelDao;
use Illuminate\Support\Collection;

class ParticipantAwaitingCancelSettingRepository extends EloquentBaseRepository implements ParticipantAwaitingCancelSettingRepositoryInterface
{
    /**
     * @param ModelDao $model
     */
    public function __construct(ModelDao $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @return ParticipantAwaitingCancelSetting|null
     */
    public function getById(int $id): ?ParticipantAwaitingCancelSetting
    {
        return parent::findById($id);
    }

    /**
     * @param ParticipantAwaitingCancelSetting $awaitingCancel
     * @return ParticipantAwaitingCancelSetting
     */
    public function save(ParticipantAwaitingCancelSetting $awaitingCancel): ParticipantAwaitingCancelSetting
    {
        return $this->createModelDAO($awaitingCancel->getId())->saveData($awaitingCancel);
    }

    /**
     * @param ParticipantAwaitingCancelSetting $awaitingCancel
     * @return bool
     */
    public function delete(ParticipantAwaitingCancelSetting $awaitingCancel): bool
    {
        return parent::deleteById($awaitingCancel->getId());
    }

    /**
     * @param int $gender
     * @param int $dateId
     * @param int $daysBefore
     * @return float
     */
    public function getRatioBy(int $gender, int $dateId, int $daysBefore): float
    {
        $awaitingCancel = $this->createQuery()
            ->where('gender', $gender)
            ->where('dating_day_id', $dateId)
            ->where('days_before', $daysBefore)
            ->first();

        return $awaitingCancel ? $awaitingCancel->ratio : 0.0;
    }

    /**
     * @return ParticipantAwaitingCancelSetting[]|Collection
     */
    public function getAll(): Collection
    {
        return $this->transformCollection(
            $this->createQuery()
                ->with('datingDay')
                ->orderBy('dating_day_id')
                ->orderBy('gender')
                ->orderBy('days_before')
                ->get()
        );
    }


    /**
     * Get recommendation settings
     *
     * @param int|null $datingDayId
     * @param int|null $gender
     * @return ParticipantAwaitingCancelSetting[]|Collection
     */
    public function getCollection(?int $datingDayId, ?int $gender): Collection
    {
        $builder = $this->createQuery();
        if ($datingDayId != null) {
            $builder = $builder->where('dating_day_id', $datingDayId);
        }
        if ($gender != null) {
            $builder = $builder->where('gender', $gender);
        }
        $builder = $builder->with('datingDay')
            ->orderBy('dating_day_id')
            ->orderBy('gender')
            ->orderBy('days_before');
        return $this->transformCollection($builder->get());
    }

    /**
     * @param int $dateId
     * @param int $gender
     * @param array $dayRatios format: [ ['days_before' => int, 'ratio' => float] ]
     * @return void
     * @throws \Exception
     */
    public function bulkSet(int $dateId, int $gender, array $dayRatios): void
    {
        $format = [
            'dating_day_id' => $dateId,
            'gender' => $gender
        ];
        foreach ($dayRatios as $dayRatio) {
            $this->model->updateOrCreate(
                [
                    'dating_day_id' => $format['dating_day_id'],
                    'gender' => $format['gender'],
                    'days_before' => $dayRatio['days_before']
                ],
                array_merge($format, $dayRatio)
            );
        }
    }
}
