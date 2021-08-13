<?php

namespace Bachelor\Domain\FeedbackManagement\Feedback\Services;

use Bachelor\Domain\DatingManagement\Dating\Models\Dating;
use Bachelor\Domain\FeedbackManagement\Feedback\Enums\CalculateableDatingReport;
use Bachelor\Domain\FeedbackManagement\Feedback\Event\FeedbackCreated;
use Bachelor\Domain\FeedbackManagement\Feedback\Factories\FeedbackFactory;
use Bachelor\Domain\FeedbackManagement\Feedback\Interfaces\FeedbackRepositoryInterface;
use Bachelor\Domain\FeedbackManagement\Feedback\Models\Feedback;
use Bachelor\Domain\PaymentManagement\Plan\Enum\CostPlan;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Models\User;
use Illuminate\Support\Facades\DB;
use PHPUnit\Util\Exception;

use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\NotificationManagement\Email\Interfaces\NotificationEmailMessageRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\UserPlanRepositoryInterface;
use Bachelor\Utility\Helpers\Utility;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class FeedbackDomainService
{
    /**
     * @var FeedbackRepositoryInterface
     */
    protected $feedbackEloquentRepository;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var NotificationEmailMessageRepositoryInterface
     */
    protected $notificationEmailMessageRepository;

    /**
     * @var UserPlanRepositoryInterface
     */
    protected $userPlanRepository;

    /**
     * UserReviewRepository constructor.
     * @param FeedbackRepositoryInterface $feedbackEloquentRepository
     * @param UserRepositoryInterface $userRepository
     * @param NotificationEmailMessageRepositoryInterface $notificationEmailMessageRepository
     * @param UserPlanRepositoryInterface $userPlanRepository
     */
    public function __construct(
        FeedbackRepositoryInterface $feedbackEloquentRepository,
        UserRepositoryInterface $userRepository,
        NotificationEmailMessageRepositoryInterface $notificationEmailMessageRepository,
        UserPlanRepositoryInterface $userPlanRepository
    )
    {
        $this->feedbackEloquentRepository = $feedbackEloquentRepository;
        $this->userRepository = $userRepository;
        $this->notificationEmailMessageRepository = $notificationEmailMessageRepository;
        $this->userPlanRepository = $userPlanRepository;
    }

    /**
     * @param Dating $datingEntity
     * @param int $feedbackByUSerId
     * @param array $params
     * @throws \Exception
     */
    public function handleStoreFeedback(Dating $datingEntity, int $feedbackByUSerId, array $params)
    {
        $feedbackByUser = $this->userRepository->getById($feedbackByUSerId);
        $feedbackForUser = $this->userRepository->getById($datingEntity->getPartnerDatingUserByUser($feedbackByUser)->getUserId());

        $params['calculateable_dating_report'] = now()->lt($datingEntity->getDatingDay()->getDeadlineFBCalcForReport())
            ? CalculateableDatingReport::Enable : CalculateableDatingReport::Disable;

        $feedbackEntity = (new FeedbackFactory())->makeFeedbackEntity($datingEntity, $feedbackForUser, $feedbackByUser, $params);

        if ($this->feedbackEloquentRepository->handleStoreFeedback($feedbackEntity)) {
            FeedbackCreated::dispatch($feedbackEntity->getFeedbackFor(), $datingEntity);
        }
    }

    /**
     * Get key for feedback notification
     *
     * @param int $lastSatisfaction
     * @param User $user
     * @return string
     */
    public function getKeyForFeedbackNotification(int $lastSatisfaction, User $user): ?string
    {
        $longTermPlanRecommendationMale = config('notification_keys.notification_long_term_plan_recommendation_male');
        $premiumAndLongTermPlanRecommendationMale = config('notification_keys.notification_premium_and_long_term_plan_recommendation_male');
        $changePreferenceRecommendationMale = config('notification_keys.notification_change_preference_recommendation_male');
        $referralRecommendationMale = config('notification_keys.notification_referral_recommendation_male');

        if ($lastSatisfaction < 3) {
            return $user->getGender() == UserGender::Female
                ? config('notification_keys.change_preference_recommendation_to_female')
                : $changePreferenceRecommendationMale;
        }

        if ($user->getGender() == UserGender::Female) {
            return config('notification_keys.notification_suggestion_for_invite_after_feedback_female');
        }

        $lastEmail = $this->notificationEmailMessageRepository->getLastInKeysByUserId($user->getId(), [
            $longTermPlanRecommendationMale,
            $premiumAndLongTermPlanRecommendationMale,
            $referralRecommendationMale,
            $changePreferenceRecommendationMale
        ]);

        if (!$lastEmail || in_array($lastEmail->getKey(), [
            $longTermPlanRecommendationMale,
            $premiumAndLongTermPlanRecommendationMale,
            $changePreferenceRecommendationMale
        ])) {
            return $referralRecommendationMale;
        }

        if ($lastEmail && $lastEmail->getKey() == $referralRecommendationMale) {
            $costPlanKey = $this->userPlanRepository->getActiveUserPlanByUserId($user->getId())->getPlan()->getCostPlanKey();
            if ($costPlanKey == CostPlan::Premium) {
                return $longTermPlanRecommendationMale;
            } else {
                return $premiumAndLongTermPlanRecommendationMale;
            }
        }

        Log::error('notification key is not found in getKeyForFeedbackNotification', [
            'user_id' => $user->getId()
        ]);
        return null;
    }

    /**
     * @param Collection $feedbacks
     * @return float
     */
    public function calculateBRate(Collection $feedbacks) : float
    {
        $fbsByNoLowRate = $feedbacks->filter(function (Feedback $feedback) {
            $partnerBRate = $feedback->getFeedbackBy()->getBRate();
            return $partnerBRate > config('constants.limit_rating_user_condition');
        });

        return round($fbsByNoLowRate->avg(function (Feedback $fb) {
            return $fb->getFeedbackUserReview()->getBSuitable();
        }), 1);
    }
}
