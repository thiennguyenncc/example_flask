<?php

namespace Bachelor\Domain\MasterDataManagement\Area\Traits;

trait AreaDataExtractorTrait
{
    /**
     * Get base prefecture data
     *
     * @param array $param
     * @return array
     */
    protected function getBaseAreaData(array $param) : array
    {
        // Retrieve the prefecture data
        return $this->areaRepository->buildIndexQuery($param)
            ->simplePaginate(
                $this->areaRepository->getModel()
                    ->getPerPage()
            )->toArray();
    }
}
