<?php

namespace Bachelor\Port\Secondary\Database\DatingManagement\ParticipantRecommendationSetting\Repository;

use Bachelor\Domain\DatingManagement\ParticipantRecommendationSetting\Interfaces\ParticipantRecommendationSettingRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantRecommendationSetting\Models\ParticipantRecommendationSetting;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantRecommendationSetting\ModelDao\ParticipantRecommendationSetting as ModelDao;
use Illuminate\Support\Collection;

class ParticipantRecommendationSettingRepository extends EloquentBaseRepository implements ParticipantRecommendationSettingRepositoryInterface
{
    /**
     * EloquentMatchingDateRepository constructor.
     * @param ModelDao $model
     */
    public function __construct(ModelDao $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @return ParticipantRecommendationSetting|null
     */
    public function getById(int $id): ?ParticipantRecommendationSetting
    {
        return parent::findById($id);
    }

    /**
     * @param ParticipantRecommendationSetting $recommendation
     * @return ParticipantRecommendationSetting
     */
    public function save(ParticipantRecommendationSetting $recommendation): ParticipantRecommendationSetting
    {
        return $this->createModelDAO($recommendation->getId())->saveData($recommendation);
    }

    /**
     * @param ParticipantRecommendationSetting $recommendation
     * @return bool
     */
    public function delete(ParticipantRecommendationSetting $recommendation): bool
    {
        return parent::deleteById($recommendation->getId());
    }

    /**
     * @param int $gender
     * @param int $dateId
     * @param int $daysBefore
     * @return float
     */
    public function getRatioBy(int $gender, int $dateId, int $daysBefore): float
    {
        $recommendation = $this->createQuery()
            ->where('gender', $gender)
            ->where('dating_day_id', $dateId)
            ->where('days_before', $daysBefore)
            ->first();

        return $recommendation ? $recommendation->ratio : 0.0;
    }

    /**
     * Get recommendation settings
     *
     * @return ParticipantRecommendationSetting[]|Collection
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
     * @return ParticipantRecommendationSetting[]|Collection
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
     * Set recommendations
     *
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
