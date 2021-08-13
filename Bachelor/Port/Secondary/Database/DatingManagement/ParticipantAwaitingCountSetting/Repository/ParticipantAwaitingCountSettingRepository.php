<?php


namespace Bachelor\Port\Secondary\Database\DatingManagement\ParticipantAwaitingCountSetting\Repository;


use Bachelor\Domain\DatingManagement\ParticipantAwaitingCountSetting\Interfaces\ParticipantAwaitingCountSettingRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantAwaitingCountSetting\Models\ParticipantAwaitingCountSetting;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantAwaitingCountSetting\ModelDao\ParticipantAwaitingCountSetting as ModelDao;
use Illuminate\Support\Collection;

class ParticipantAwaitingCountSettingRepository extends EloquentBaseRepository implements ParticipantAwaitingCountSettingRepositoryInterface
{
    /**
     * ParticipantAwaitingCountSettingRepository constructor.
     * @param ModelDao $model
     */
    public function __construct(ModelDao $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $gender
     * @param int $datingDayId
     * @param int $prefectureId
     * @return Collection
     */
    public function getSettings(int $gender, int $datingDayId, int $prefectureId): Collection
    {
        $settingCollection = $this->createQuery()
            ->where('gender', $gender)
            ->where('dating_day_id', $datingDayId)
            ->where('prefecture_id', $prefectureId)
            ->get();

        return $this->transformCollection($settingCollection);
    }

    /**
     * @param Collection $models
     * @return bool
     */
    public function saveSettings(Collection $models): bool
    {
        foreach ($models as $model) {
            /** @var ParticipantAwaitingCountSetting $model*/
            $this->model->updateOrCreate([
                'gender' => $model->getGender(),
                'prefecture_id' => $model->getPrefectureId(),
                'dating_day_id' => $model->getDatingDayId(),
                'type' => $model->getType()
            ],[
                'count' => $model->getCount()
            ]);
        }
        return true;
    }
}
