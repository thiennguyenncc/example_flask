<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\Repository;

use Bachelor\Domain\MasterDataManagement\Prefecture\Interfaces\PrefectureRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\Prefecture\Model\Prefecture;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\ModelDao\Prefecture as PrefectureDao;
use Bachelor\Port\Secondary\Database\MasterDataManagement\Prefecture\ModelDao\PrefectureTranslation;
use Bachelor\Utility\Enums\Status;
use Illuminate\Support\Collection;

class EloquentPrefectureRepository extends EloquentBaseRepository implements PrefectureRepositoryInterface
{
    /**
     * EloquentPrefectureRepository constructor.
     * @param PrefectureDao $prefecture
     */
    public function __construct(PrefectureDao $prefecture)
    {
        parent::__construct($prefecture);
    }

    /**
     * @return Collection
     */
    public function getAllPrefectures(): Collection
    {
        return $this->getAllDomainModelCollection();
    }

    /**
     * @param $value
     * @param string $column
     * @return Prefecture|null
     */
    public function getSpecificPrefecture($value, string $column = 'id'): ?Prefecture
    {
        return $this->modelDAO->getSpecificData($value, $column)->first()?->toDomainEntity();
    }

    /**
     * @return Collection
     */
    public function getAllDomainModelCollection(): Collection
    {
        return $this->transformCollection(
            $this->modelDAO->newModelQuery()->where('status', '!=', Status::Deleted)->get()
        );
    }

    /**
     * @param array $params = [
     *      'search' => [
     *          'column_name1' => 'value1',
     *          'column_name2' => 'value2',
     *      ],
     *      'filter' => [
     *          'column_name1' => 'value1',
     *          'column_name2' => 'value2',
     *      }
     * ]
     * @return Collection
     */
    public function getSpecifiedPrefectures(array $params): Collection
    {
        return $this->getSpecificDomainModelCollections($params);
    }

    /**
     * Create new prefecture
     *
     * @param Prefecture $prefecture
     * @return Prefecture
     */
    public function save(Prefecture $prefecture): Prefecture
    {
        return $this->createModelDAO($prefecture->getId())->saveData($prefecture);
    }

    /**
     * Create new register option translation
     *
     * @param Prefecture $prefecture
     * @param array $data
     * @return mixed
     */
    public function updateOrCreatePrefectureTranslation(Prefecture $prefecture, array $data)
    {
        $prefectureDao = $this->createModelDAO($prefecture->getId());

        return $prefectureDao->prefectureTranslations()->updateOrCreate($data);
    }

    /**
     * @param int $status
     * @return Collection
     */
    public function getPrefectureCollectionByStatus(int $status): Collection
    {
        return $this->transformCollection(
            $this->modelDAO->newModelQuery()->where('status', '=', $status)->get()
        );
    }
}
