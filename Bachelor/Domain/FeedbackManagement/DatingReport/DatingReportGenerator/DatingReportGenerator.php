<?php

namespace Bachelor\Domain\FeedbackManagement\DatingReport\DatingReportGenerator;

use Bachelor\Domain\FeedbackManagement\DatingReport\Interfaces\DatingReportRepositoryInterface;
use Bachelor\Domain\FeedbackManagement\Feedback\Interfaces\FeedbackRepositoryInterface;
use Bachelor\Domain\FeedbackManagement\Feedback\Models\Feedback;
use Bachelor\Domain\MasterDataManagement\ReviewBox\Enums\GoodBadType;
use Bachelor\Domain\MasterDataManagement\ReviewBox\Interfaces\ReviewBoxRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Collection;

class DatingReportGenerator
{
    /**
     * @var DatingReportRepositoryInterface
     */
    protected $datingReportRepository;

    /**
     * @var FeedbackRepositoryInterface
     */
    protected $feedbackRepository;

    /**
     * @var ReviewBoxRepositoryInterface
     */
    protected $reviewBoxRepository;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    public function __construct(
        DatingReportRepositoryInterface $datingReportRepository,
        FeedbackRepositoryInterface $feedbackRepository,
        ReviewBoxRepositoryInterface $reviewBoxRepository,
        UserRepositoryInterface $userRepository
    )
    {
        $this->datingReportRepository = $datingReportRepository;
        $this->feedbackRepository = $feedbackRepository;
        $this->reviewBoxRepository = $reviewBoxRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(Collection $feedbacks): array
    {
        $goodFactorReportDatingData = $this->calculateGoodFactorDatingReportInfo($feedbacks);

        $fbsByNoLowRate = $feedbacks->filter(function (Feedback $feedback) {
            $partnerBRate = $feedback->getFeedbackBy()->getBRate();
            return $partnerBRate > config('constants.limit_rating_user_condition');
        });

        $complaintReportDatingData = $this->calculateComplaintDatingReportInfo($fbsByNoLowRate);
        $averageFourReview = $this->getAverageFourReview($fbsByNoLowRate);

        return [
            'reportDatingData' => $goodFactorReportDatingData,
            'averageFourReview' => $averageFourReview,
            'complaintReportDatingData' => $complaintReportDatingData
        ];
    }

    public function calculateComplaintDatingReportInfo($feedbacks): array
    {
        $complaints = $this->reviewBoxRepository->getReviewBoxes(GoodBadType::Complaint);

        $complaintsWithPoint = $this->refactorReviewBox($complaints, 'complaint');

        // calculate total point of each good factor loop each review
        foreach ($feedbacks as $feedback) {
            if ($feedback->getFeedbackBy()->getBRate() > config('constants.limit_rating_user_condition')) {
                $complaintsOfFacesSelect = $feedback->getFeedbackUserReview()->getFaceComplaint();
                $complaintsOfPersonalitiesSelect = $feedback->getFeedbackUserReview()->getPersonalityComplaint();
                $complaintsOfBehaviorsSelect = $feedback->getFeedbackUserReview()->getBehaviourComplaint();

                $this->calculatePointOfReviewBox($complaintsOfFacesSelect, $feedback, $complaintsWithPoint, 'FacePoint');
                $this->calculatePointOfReviewBox($complaintsOfPersonalitiesSelect, $feedback, $complaintsWithPoint, 'PersonalityPoint');
                $this->calculatePointOfReviewBox($complaintsOfBehaviorsSelect, $feedback, $complaintsWithPoint, 'BehaviourPoint');
            }
        }

        return  $this->orderReviewBoxFollowPoint($complaintsWithPoint, 'complaint');
    }

    public function calculatePointOfReviewBox($reviewBoxList, $feedback, &$reviewBoxWithPoint, $attribute)
    {
        foreach ((array)$reviewBoxList as $reviewBox) {
            if (isset($reviewBoxWithPoint[$reviewBox])) {
                $reviewBoxWithPoint[$reviewBox]['total_point'] += $feedback->getFeedbackUserReview()->{'get' . $attribute}();
            }
        }
    }

    public function calculateGoodFactorDatingReportInfo($feedbacks): array
    {
        $goodFactors = $this->reviewBoxRepository->getReviewBoxes(GoodBadType::GoodFactor);

        $goodFactorsWithPoint = $this->refactorReviewBox($goodFactors, 'good_factor');

        // calculate total point of each good factor loop each review
        foreach ($feedbacks as $feedback) {
            $goodFactorsOfFacesSelect = $feedback->getFeedbackUserReview()->getFaceGoodFactor();
            $goodFactorsOfPersonalitiesSelect = $feedback->getFeedbackUserReview()->getPersonalityGoodFactor();
            $goodFactorsOfBehaviorsSelect = $feedback->getFeedbackUserReview()->getBehaviourGoodFactor();

            $this->calculatePointOfReviewBox($goodFactorsOfFacesSelect, $feedback, $goodFactorsWithPoint, 'FacePoint');
            $this->calculatePointOfReviewBox($goodFactorsOfPersonalitiesSelect, $feedback, $goodFactorsWithPoint, 'PersonalityPoint');
            $this->calculatePointOfReviewBox($goodFactorsOfBehaviorsSelect, $feedback, $goodFactorsWithPoint, 'BehaviourPoint');
        }

        return  $this->orderReviewBoxFollowPoint($goodFactorsWithPoint, 'good_factor');
    }

    public function refactorReviewBox($reviewBoxes, $type): array
    {
        $results = [];
        foreach ($reviewBoxes as $reviewBox) {
            $results[$reviewBox->getId()] = [
                $type . '_label' => $reviewBox->getLabel(),
                $type . '_description' => $reviewBox->getDescription(),
                'review_point_label' => $reviewBox->getReviewPoint()->getLabel(),
                'star_category_label' => $reviewBox->getStarCategory()->getLabel(),
                'star_category_id' => $reviewBox->getStarCategory()->getId(),
                'total_point' => 0
            ];
        }

        return $results;
    }

    public function orderReviewBoxFollowPoint($reviewBoxesWithPoint, $type): array
    {
        $result = [];
        $reviewBoxFollowStarCategoryList = [];

        // calculate total point with each star category
        foreach ($reviewBoxesWithPoint as $key => $reviewBox) {
            $result[$reviewBox['star_category_id']] = [
                'star_category_label' => $reviewBox['star_category_label'],
                'total_point' => (isset($result[$reviewBox['star_category_id']]['total_point'])
                    && $result[$reviewBox['star_category_id']]['total_point'] < $reviewBox['total_point']) ?
                    $reviewBox['total_point'] : (isset($result[$reviewBox['star_category_id']]['total_point']) ?
                        $result[$reviewBox['star_category_id']]['total_point'] : $reviewBox['total_point'])
            ];
            if ($reviewBox['total_point']) {
                $reviewBoxFollowStarCategoryList[$reviewBox['star_category_id']][] = [
                    $type . '_description' => $reviewBox[$type . '_description'],
                    $type . '_point' => $reviewBox['total_point']
                ];
            }

        }
        // Sort total point review box follow star category
        foreach ($reviewBoxFollowStarCategoryList as &$value) {
            uasort($value, function ($item1, $item2) use ($type){
                if ($item1[$type . '_point'] == $item2[$type . '_point']) return 0;
                if ($type == 'good_factor') {
                    return ($item1[$type . '_point'] < $item2[$type . '_point']) ? 1 : -1;
                } elseif ($type == 'complaint') {
                    return ($item1[$type . '_point'] > $item2[$type . '_point']) ? 1 : -1;
                }
                return null;
            });
        }

        // Sort point follow star category
        uasort($result, function ($item1, $item2) use ($type){
            if ($item1['total_point'] == $item2['total_point']) return 0;

            if ($type == 'good_factor') {
                return ($item1['total_point'] < $item2['total_point']) ? 1 : -1;
            } elseif ($type == 'complaint') {
                return ($item1['total_point'] > $item2['total_point']) ? 1 : -1;
            }

            return null;
        });

        // apply 3 review box to star category
        $limitStarCategory = 0;
        foreach ($result as $key => &$item) {
            if (! $item['total_point']) {
                unset($result[$key]);
                continue;
            }
            if ($limitStarCategory < config('constants.limit_star_category')) {
                $count = 0;
                if (isset($reviewBoxFollowStarCategoryList[$key])) {
                    foreach ($reviewBoxFollowStarCategoryList[$key] as $reviewBoxFollowStarCategory) {
                        if ($count == config('constants.limit_show_review_box')) {
                            break;
                        }
                        $item[$type . '_famous'][$count + 1] = [
                            $type . '_description' => $reviewBoxFollowStarCategory[$type . '_description'],
                            $type . '_point' => $reviewBoxFollowStarCategory[$type . '_point']
                        ];
                        $count ++;
                    }
                }
                $limitStarCategory ++;
            } else {
                unset($result[$key]);
            }
        }

        return $result;
    }

    public function getAverageFourReview($feedbacks): array
    {
        $reviewCount = $feedbacks->count();
        $facePoint = 0;
        $personalityPoint = 0;
        $behaviorPoint = 0;
        $faceCount = $reviewCount;
        $personalityCount = $reviewCount;
        $behaviorCount = $reviewCount;

        foreach ($feedbacks as $feedback) {
            if ($feedback->getFeedbackBy()->getBRate() <= config('constants.limit_rating_user_condition')) {
                if ($feedback->getFeedbackUserReview()->getFacePoint() > config('constants.limit_point_condition')) {
                    $facePoint += $feedback->getFeedbackUserReview()->getFacePoint();
                } else {
                    $faceCount --;
                }

                if ($feedback->getFeedbackUserReview()->getPersonalityPoint() > config('constants.limit_point_condition')) {
                    $personalityPoint += $feedback->getFeedbackUserReview()->getPersonalityPoint();
                } else {
                    $personalityCount --;
                }

                if ($feedback->getFeedbackUserReview()->getBehaviourPoint() > config('constants.limit_point_condition')) {
                    $behaviorPoint += $feedback->getFeedbackUserReview()->getBehaviourPoint();
                } else {
                    $behaviorCount --;
                }
            } else {
                $facePoint += $feedback->getFeedbackUserReview()->getFacePoint();
                $personalityPoint += $feedback->getFeedbackUserReview()->getPersonalityPoint();
                $behaviorPoint += $feedback->getFeedbackUserReview()->getBehaviourPoint();
            }

        }

        $facePointAverage = $faceCount ? round($facePoint / $faceCount,1) : config('constants.default_average_point');
        $personalityPointAverage = $personalityCount ? round($personalityPoint / $personalityCount,1) : config('constants.default_average_point');
        $behaviorPointAverage = $behaviorCount ?  round($behaviorPoint / $behaviorCount,1) : config('constants.default_average_point');

        return [
            'facePointAverage' => $facePointAverage,
            'personalityPointAverage' => $personalityPointAverage,
            'behaviorPointAverage' => $behaviorPointAverage,
        ];
    }
}
