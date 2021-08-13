<?php

namespace Bachelor\Domain\FeedbackManagement\DatingReport\Services;

use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\DatingManagement\Dating\Models\Dating;
use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\FeedbackManagement\DatingReport\DatingReportGenerator\DatingReportGenerator;
use Bachelor\Domain\FeedbackManagement\DatingReport\Events\DatingReportGenerated;
use Bachelor\Domain\FeedbackManagement\DatingReport\Interfaces\DatingReportRepositoryInterface;
use Bachelor\Domain\FeedbackManagement\DatingReport\Models\DatingReport;
use Bachelor\Domain\FeedbackManagement\DatingReport\Models\DatingReportGenerateFeedback;
use Bachelor\Domain\FeedbackManagement\Feedback\Enums\CalculateableDatingReport;
use Bachelor\Domain\FeedbackManagement\Feedback\Enums\FeedbackProperty;
use Bachelor\Domain\FeedbackManagement\Feedback\Interfaces\FeedbackRepositoryInterface;
use Bachelor\Domain\FeedbackManagement\Feedback\Models\Feedback;
use Bachelor\Domain\MasterDataManagement\ReviewBox\Interfaces\ReviewBoxRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\ReviewPoint\Interfaces\ReviewPointRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Port\Secondary\Database\Base\SystemDate\Interfaces\EloquentSystemDateInterface;
use Exception;
use Illuminate\Support\Collection;

class DatingReportDomainService
{
    /**
     * @var DatingReportGenerator
     */
    protected $datingReportGenerator;

    /**
     * @var DatingReportRepositoryInterface
     */
    protected $datingReportRepository;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var ReviewBoxRepositoryInterface
     */
    protected $reviewBoxRepository;

    /**
     * @var ReviewPointRepositoryInterface
     */
    protected $reviewPointRepository;

    /**
     * @var FeedbackRepositoryInterface
     */
    protected $feedbackRepository;

    /**
     * @var DatingRepositoryInterface
     */
    protected $datingRepository;

    /**
     * @var EloquentSystemDateInterface
     */
    protected $systemDateRepository;


    public function __construct(
        DatingReportGenerator $datingReportGenerator,
        DatingReportRepositoryInterface $datingReportRepository,
        UserRepositoryInterface $userRepository,
        ReviewBoxRepositoryInterface $reviewBoxRepository,
        ReviewPointRepositoryInterface $reviewPointRepository,
        FeedbackRepositoryInterface $feedbackRepository,
        DatingRepositoryInterface $datingRepository,
        EloquentSystemDateInterface $systemDateRepository
    )
    {
        $this->datingReportGenerator = $datingReportGenerator;
        $this->datingReportRepository = $datingReportRepository;
        $this->userRepository = $userRepository;
        $this->reviewBoxRepository = $reviewBoxRepository;
        $this->reviewPointRepository = $reviewPointRepository;
        $this->feedbackRepository = $feedbackRepository;
        $this->datingRepository = $datingRepository;
        $this->systemDateRepository = $systemDateRepository;
    }

    /**
     * @param int $userId
     * @param Dating $datingEntity
     * @throws \Exception
     */
    public function generateDatingReport(User $user, DatingDay $datingDay) : ?DatingReport
    {
        $userId = $user->getId();
        $latestFeedbacks = $this->feedbackRepository->getLatestFeedbacksFor(
            $userId,
            CalculateableDatingReport::Enable,
            config('constants.calc_fb_num_per_report'),
            [FeedbackProperty::DatingReportGenerateFeedbacks]
        );

        if ($this->getRequiredFeedbackNumberForNext($latestFeedbacks) !== 0) return null;

        $datingReportData = $this->datingReportGenerator->handle($latestFeedbacks);

        foreach ($latestFeedbacks as $feedback) {
            $datingReportGenerateFeedbacks[] = new DatingReportGenerateFeedback($feedback->getId());
        }

        $datingReportEntity = new DatingReport(
            $userId,
            collect($datingReportGenerateFeedbacks),
            $datingReportData,
            $datingDay->getDatingReportWillDisplayDate()
        );

        $report = $this->datingReportRepository->saveDatingReport($datingReportEntity);

        DatingReportGenerated::dispatch($user, $latestFeedbacks);

        return $report;
    }

    /**
     * Get requred feedback number for next dating report update
     *
     * @param Collection $feedbacks
     * @return integer
     */
    public function getRequiredFeedbackNumberForNext(Collection $latestCalcFeedbacks) : int
    {
        $feedbacksNoReport = $latestCalcFeedbacks->filter(function (Feedback $feedback) {
            if (is_null($feedback->getDatingReportGenerateFeedbacks())) throw new \Exception('DatingReportGenerateFeedbacks needs to be loaded');
            return $feedback->getDatingReportGenerateFeedbacks()->isEmpty();
        });

        return config('constants.report_generate_frequency_fb') - $feedbacksNoReport->count();
    }

    /**
     * Get info for dating report
     *
     * @param $userId
     * @param null $datingReportId
     * @return array
     */
    public function getDatingReportInfo(User $user, $datingReportId = null) : array
    {
        $userId = $user->getId();
        $feedbacks = $this->feedbackRepository->getLatestFeedbacksFor(
            $userId,
            CalculateableDatingReport::Enable,
            null,
            [FeedbackProperty::DatingReportGenerateFeedbacks]
        );

        $gender = $user->getGender();
        $goodFactorsByGender = $this->reviewBoxRepository->getGoodFactorsFollowByGender($gender);
        $reviewPoints = $this->reviewPointRepository->getReviewPoint();
        $goodFactorFollowReviewPoint = $this->mapGoodFactorToReviewPoint($goodFactorsByGender, $reviewPoints);
        $reportDating = $this->datingReportRepository->getLastDatingReportOfUser($userId);
        $feedbackCount = $feedbacks->count();
        $requiredFeedbackNumberForNext = $this->getRequiredFeedbackNumberForNext($feedbacks->take(config('constants.calc_fb_num_per_report')));

        return [
            'averageLastFourReview' => optional($reportDating)->getDatingReportData()['averageFourReview'] ?? null,
            'goodFactorFollowReviewPoint' => $goodFactorFollowReviewPoint,
            'numberReviewNeedUpdateReportDating' => $requiredFeedbackNumberForNext,
            'reportDating' => optional($reportDating)->getDatingReportData()['reportDatingData'] ?? null,
            'complaintReportDatingData' => optional($reportDating)->getDatingReportData()['complaintReportDatingData'] ?? null,
            'totalReview' => $feedbackCount,
            'bRate' => empty($reportDating) ? null : $user->getBRate()
        ];
    }

    private function mapGoodFactorToReviewPoint($goodFactorsByGender, $reviewPoints): array
    {
        $result = [];
        foreach ($reviewPoints as $reviewPoint) {
            foreach ($goodFactorsByGender as $key => $goodFactor) {
                if ($reviewPoint->getId() == $goodFactor->getReviewPoint()->getId()) {
                    $result[$reviewPoint->getKey()][] = [
                        'id' => $goodFactor->getId(),
                        'type' => $goodFactor->getGoodBadType(),
                        'label' => $goodFactor->getLabel(),
                        'description' => $goodFactor->getDescription(),
                        'active_with' => $goodFactor->getFeedbackByGender(),
                        'visible' => $goodFactor->getVisible(),
                        'order' => $goodFactor->getOrderInFeedback(),
                        'review_point_id' => $goodFactor->getReviewPointId(),
                        'star_category_id' => $goodFactor->getStarCategoryId()
                    ];
                    unset($goodFactorsByGender[$key]);
                }
            }
        }

        return $result;
    }
}
