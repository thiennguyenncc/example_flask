<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\Repository;

use Bachelor\Domain\MasterDataManagement\DatingPlace\Interfaces\DatingPlaceRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Model\DatingPlace;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Model\DatingPlaceOpenCloseSetting;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Model\DatingPlaceTranslation;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\ModelDao\DatingPlace as DatingPlaceDao;
use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\ModelDao\DatingPlaceOpenCloseSetting as DatingPlaceOpenCloseSettingDao;
use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\ModelDao\DatingPlaceTranslation as DatingPlaceTranslationDao;
use Bachelor\Utility\Enums\Status;
use Illuminate\Support\Collection;

class EloquentDatingPlaceRepository extends EloquentBaseRepository implements DatingPlaceRepositoryInterface
{
    /**
     * EloquentAreaRepository constructor.
     * @param DatingPlaceDao $datingPlace
     */
    public function __construct(DatingPlaceDao $datingPlace)
    {
        parent::__construct($datingPlace);
    }

    /**
     * @param $value
     * @param string $column
     * @return DatingPlace
     * @deprecated
     */
    public function getSpecificDatingPlace($value, string $column = 'id'): DatingPlace
    {
        return $this->modelDAO->getSpecificData($value, $column)->first()->toDomainEntity();
    }

    /**
     * Create new dating place translation
     *
     * @param DatingPlace $datingPlace
     * @param array $data
     * @return DatingPlace
     */
    public function createDatingPlaceTranslation(DatingPlace $datingPlace, array $data)
    {
        $datingPlaceDao = $this->createModelDAO($datingPlace->getId());

        return $datingPlaceDao->datingPlaceTranslations()->updateOrCreate($data);
    }

    /**
     * Create new dating place
     *
     * @param DatingPlace $datingPlace
     * @param array $params
     * @return DatingPlace
     */
    public function save(DatingPlace $datingPlaceEntity): DatingPlace
    {
        $datingPlaceEntityWithId = $this->createModelDAO($datingPlaceEntity->getId())->saveData($datingPlaceEntity);

        /** @var DatingPlace $datingPlaceEntityWithId */
        $translations = $datingPlaceEntityWithId->getDatingPlaceTranslations();

        $translations->map(function (
            DatingPlaceTranslation $translationEntity
        ) use ($datingPlaceEntityWithId) {
            $translationEntity->setDatingPlaceId($datingPlaceEntityWithId->getId());
            $translationDAO = new DatingPlaceTranslationDAO();
            $translationEntityWithId = $translationDAO->saveData($translationEntity);

            return $translationEntityWithId;
        });

        $openCloseSettings = $datingPlaceEntityWithId->getDatingPlaceOpenCloseSettings();

        $openCloseSettings->map(function (
            DatingPlaceOpenCloseSetting $openCloseSettingEntity
        ) use ($datingPlaceEntityWithId) {
            $openCloseSettingEntity->setDatingPlaceId($datingPlaceEntityWithId->getId());
            $openCloseSettingDao = new DatingPlaceOpenCloseSettingDao();
            $openCloseSettingEntityWithId = $openCloseSettingDao->saveData($openCloseSettingEntity);

            return $openCloseSettingEntityWithId;
        });

        $datingPlaceEntityWithId->setDatingPlaceTranslations($translations);
        $datingPlaceEntityWithId->setDatingPlaceOpenCloseSettings($openCloseSettings);

        return $datingPlaceEntityWithId;
    }

    /**
     * @return Collection
     */
    public function getAllDomainModelCollection(): Collection
    {
        return $this->transformCollection($this->modelDAO->newModelQuery()->where('status', '!=', Status::Deleted)->get());
    }

    /**
     * @return Collection
     */
    public function getAllDatingPlaces(): Collection
    {
        return $this->getAllDomainModelCollection();
    }

    /**
     * This is for applying search and filters to the query dynamically to get all required data
     *
     * @param array $params
     * @return Collection
     */
    public function getSpecifiedDatingPlaces(array $params): Collection
    {
        return $this->getSpecificDomainModelCollections($params);
    }

    /**
     * @param int $trainStationId
     * @param string $category
     * @param array $exceptDatingPlaceIds
     * @return Collection
     */
    public function getThreeDatingPlaceByTrainStationId(int $trainStationId, string $category, array $exceptDatingPlaceIds = []): Collection
    {
        $query = $this->modelDAO->newModelQuery()
            ->where('train_station_id', $trainStationId)
            ->where('category', $category)
            ->whereNotIn('id', $exceptDatingPlaceIds)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return $this->transformCollection($query);
    }

    /**
     * @param $id
     * @return DatingPlace
     */
    public function getById($id): DatingPlace
    {
        $datingPlace = $this->modelDAO->newModelQuery()
            ->where('id', $id)
            ->first();

        return $datingPlace->toDomainEntity();
    }

    /**
     * @param array $ids
     * @return Collection
     */
    public function getByIds(array $ids): Collection
    {
        $datingPlaces = parent::findByIds($ids)->get();

        return $this->transformCollection($datingPlaces);
    }

    /**
     * @return Collection
     */
    public function getDatingPlaces(): Collection
    {
        $datingPlaces = $this->modelDAO->newModelQuery()->where('status', Status::Active)->get();

        return $this->transformCollection($datingPlaces);
    }
}
