<?php
namespace Bachelor\Domain\MasterDataManagement\Area\Services;

use Bachelor\Domain\MasterDataManagement\Area\Interfaces\AreaRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\Area\Model\Area;
use Bachelor\Domain\MasterDataManagement\Area\Traits\AreaDataExtractorTrait;
use Bachelor\Domain\MasterDataManagement\Area\Traits\AreaDataFormatterTrait;

class AreaService
{
    use AreaDataExtractorTrait, AreaDataFormatterTrait;

    /*
     * @var AreaRepositoryInterface
     */
    private AreaRepositoryInterface $areaRepository;

    /**
     * AreaRepositoryInterface constructor.
     *
     * @param AreaRepositoryInterface $areaRepository
     */
    public function __construct(AreaRepositoryInterface $areaRepository)
    {
        $this->areaRepository = $areaRepository;
    }

    /**
     * Get the area data
     *
     * @param array $param
     * @return array
     */
    public function get(array $param): array
    {
        // Get base prefecture data
        $prefecture = self::getBaseAreaData($param);

        // Retrieve the filter list
        $prefecture['filter'] = $this->areaRepository->getFilter();

        // Return prefecture data
        return $prefecture;
    }

    /**
     * Create new area
     *
     * @param array $param
     * @return bool
     */
    public function create(array $param): bool
    {
        $areaData = self::formatDataForArea($param);

        return ! empty($this->areaRepository->create($areaData['area'])
            ->areaTranslations()
            ->createMany($areaData['areaTranslations']));
    }

    /**
     * Update the area data
     *
     * @param int $areaId
     * @param array $param
     * @return bool
     */
    public function update(int $areaId, array $param): bool
    {
        return self::initializeArea($areaId)->updateArea($param);
    }

    /**
     * Delete area
     *
     * @param int $areaId
     * @return bool
     */
    public function delete(int $areaId): bool
    {
        return self::initializeArea($areaId)->deleteArea();
    }

    /**
     * Initialize the area
     *
     * @param int $areaId
     * @return Area
     */
    protected function initializeArea(int $areaId): Area
    {
        return (new Area($this->areaRepository->findById($areaId)));
    }
}
