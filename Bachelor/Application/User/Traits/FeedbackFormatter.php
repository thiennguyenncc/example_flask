<?php

namespace Bachelor\Application\User\Traits;

use Illuminate\Support\Collection;

trait FeedbackFormatter
{
    public function formatReviewBoxes(Collection $reviewBoxes): array
    {
        $results = [];
        foreach ($reviewBoxes as $reviewBox) {
            array_push($results, [
                'id' => $reviewBox->getId(),
                'type' => $reviewBox->getGoodBadType(),
                'label' => $reviewBox->getLabel(),
                'description' => $reviewBox->getDescription(),
                'active_with' => $reviewBox->getFeedbackByGender(),
                'visible' => $reviewBox->getVisible(),
                'review_point_id' => $reviewBox->getReviewPointId(),
                'star_category_id' => $reviewBox->getStarCategoryId(),
                'review_point' => [
                    'label' => $reviewBox->getReviewPoint()->getLabel()
                ]
            ]);
        }

        return $results;
    }
}
