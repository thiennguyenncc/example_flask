<?php

namespace Bachelor\Domain\MasterDataManagement\Prefecture\Traits;

trait PrefectureDataExtractorTrait
{
    /**
     * Get base prefecture data
     *
     * @param array $param
     * @return array
     */
    protected function getBasePrefectureData(array $param) : array
    {
        // Retrieve the prefecture data
        return $this->prefectureRepository->buildIndexQuery($param)
            ->simplePaginate(
                $this->prefectureRepository->getModel()
                    ->getPerPage()
            )->toArray();
    }
}
