<?php

namespace Bachelor\Domain\MasterDataManagement\ReviewPoint\Interfaces;

use Illuminate\Support\Collection;

interface ReviewPointRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getReviewPoint():Collection;
}
