<?php

namespace Bachelor\Domain\MasterDataManagement\ReviewBox\Interfaces;

use Illuminate\Support\Collection;

interface ReviewBoxRepositoryInterface
{

    /**
     * @param $type
     * @return Collection
     */
    public function getReviewBoxes($type = null): Collection;

    /**
     * List good factor follow review point by gender
     *
     * @param $gender
     * @return Collection
     */
    public function getGoodFactorsFollowByGender($gender): Collection;
}
