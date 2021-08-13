<?php

namespace Bachelor\Port\Secondary\Database\MasterDataManagement\ReviewBox\Repository;

use Bachelor\Domain\MasterDataManagement\ReviewBox\Enums\FeedbackByGender;
use Bachelor\Domain\MasterDataManagement\ReviewBox\Enums\Visible;
use Bachelor\Domain\MasterDataManagement\ReviewBox\Enums\GoodBadType;
use Bachelor\Domain\MasterDataManagement\ReviewBox\Interfaces\ReviewBoxRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\ReviewPoint\Enums\ReviewPointStatus;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\MasterDataManagement\ReviewBox\ModelDao\ReviewBox;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReviewBoxRepository extends EloquentBaseRepository implements ReviewBoxRepositoryInterface
{
    /**
     * EloquentReviewBoxRepository constructor.
     * @param ReviewBox $reviewBox
     */
    public function __construct(ReviewBox $reviewBox)
    {
        parent::__construct($reviewBox);
    }

    /**
     * @param $type
     * @return Collection
     */
    public function getReviewBoxes($type = null): Collection
    {
        $query = $this->model;

        if ($type) {
            $query = $query->where('good_bad_type', $type);
        }

        $reviewBoxes = $query
            ->where('visible', Visible::true)
            ->get();

        return $this->transformCollection($reviewBoxes);
    }

    /**
     * @param $gender
     * @return Collection
     */
    public function getGoodFactorsFollowByGender($gender): Collection
    {
        if ($gender == UserGender::Male) {
            $conditionsActiveWith = [FeedbackByGender::Both, FeedbackByGender::Male];
        }else {
            $conditionsActiveWith = [FeedbackByGender::Both, FeedbackByGender::Female];
        }

        $goodFactors =  $this->model
            ->where('good_bad_type', GoodBadType::GoodFactor)
            ->where('visible', Visible::true)
            ->whereIn('feedback_by_gender', $conditionsActiveWith)
            ->get();

        return $this->transformCollection($goodFactors);
    }
}
