<?php


namespace Bachelor\Port\Secondary\Database\MasterDataManagement\ReviewPoint\Repository;


use Bachelor\Domain\MasterDataManagement\ReviewPoint\Enums\ReviewPointStatus;
use Bachelor\Domain\MasterDataManagement\ReviewPoint\Interfaces\ReviewPointRepositoryInterface;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\MasterDataManagement\ReviewPoint\ModelDao\ReviewPoint;
use Illuminate\Support\Collection;

class ReviewPointRepository extends EloquentBaseRepository implements ReviewPointRepositoryInterface
{
    public function __construct(ReviewPoint $reviewPoint)
    {
        parent::__construct($reviewPoint);
    }

    /**
     * @return Collection
     */
    public function getReviewPoint(): Collection
    {
        $reviewPoints = $this->model->where('status', ReviewPointStatus::Active)->get();

        return $this->transformCollection($reviewPoints);
    }
}
