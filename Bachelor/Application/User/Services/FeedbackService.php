<?php

namespace Bachelor\Application\User\Services;

use Bachelor\Application\User\Traits\FeedbackFormatter;
use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\DatingManagement\Dating\Services\DatingDomainService;
use Bachelor\Domain\FeedbackManagement\Feedback\Interfaces\FeedbackRepositoryInterface;
use Bachelor\Domain\FeedbackManagement\Feedback\Services\FeedbackDomainService;
use Bachelor\Domain\MasterDataManagement\Coupon\Emums\CouponType;
use Bachelor\Domain\MasterDataManagement\ReviewBox\Interfaces\ReviewBoxRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\UserPlanRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Domain\UserManagement\UserCoupon\Services\UserCouponDomainService;
use Bachelor\Domain\UserManagement\UserInvitation\Interfaces\UserInvitationInterface;
use Illuminate\Http\Response;

use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Utility\Helpers\Utility;
use Illuminate\Support\Facades\Log;

class FeedbackService
{
    use FeedbackFormatter;
    /**
     * @var FeedbackDomainService
     */
    protected $feedbackDomainService;

    /**
     * Response Status
     */
    protected $status;

    /**
     * Response Message
     */
    protected $message;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var DatingDomainService
     */
    protected DatingDomainService $datingDomainService;

    /**
     * @var ReviewBoxRepositoryInterface
     */
    protected ReviewBoxRepositoryInterface $reviewBoxRepository;

    /**
     * @var DatingRepositoryInterface
     */
    protected DatingRepositoryInterface $datingRepository;

    /**
     * @var FeedbackRepositoryInterface
     */
    protected FeedbackRepositoryInterface $feedbackRepository;

    /**
     * @var UserPlanRepositoryInterface
     */
    protected UserPlanRepositoryInterface $userPlanRepository;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var NotificationService
     */
    protected $notificationService;

    /**
     * @var NotificationRepositoryInterface
     */
    protected $notificationRepository;

    /**
     * @var UserInvitationInterface
     */
    protected UserInvitationInterface $userInvitationRepository;

    /**
     * @var UserCouponDomainService
     */
    private UserCouponDomainService $userCouponService;

    /**
     * FeedbackService constructor.
     * @param FeedbackDomainService $feedbackDomainService
     * @param DatingDomainService $datingDomainService
     * @param ReviewBoxRepositoryInterface $reviewBoxRepository
     * @param DatingRepositoryInterface $datingRepository
     * @param UserRepositoryInterface $userRepository
     * @param NotificationService $notificationService
     * @param NotificationRepositoryInterface $notificationRepository
     * @param FeedbackRepositoryInterface $feedbackRepository
     * @param UserPlanRepositoryInterface $userPlanRepository
     * @param UserInvitationInterface $userInvitationRepository
     * @param UserCouponDomainService $userCouponService
     */
    public function __construct(
        FeedbackDomainService $feedbackDomainService,
        DatingDomainService $datingDomainService,
        ReviewBoxRepositoryInterface $reviewBoxRepository,
        DatingRepositoryInterface $datingRepository,
        UserRepositoryInterface $userRepository,
        NotificationService $notificationService,
        NotificationRepositoryInterface $notificationRepository,
        FeedbackRepositoryInterface $feedbackRepository,
        UserPlanRepositoryInterface $userPlanRepository,
        UserInvitationInterface $userInvitationRepository,
        UserCouponDomainService $userCouponService,
    )
    {
        $this->feedbackDomainService = $feedbackDomainService;
        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
        $this->datingDomainService = $datingDomainService;
        $this->datingRepository = $datingRepository;
        $this->reviewBoxRepository =$reviewBoxRepository;
        $this->userRepository = $userRepository;
        $this->notificationService = $notificationService;
        $this->notificationRepository = $notificationRepository;
        $this->feedbackRepository = $feedbackRepository;
        $this->userPlanRepository = $userPlanRepository;
        $this->userInvitationRepository = $userInvitationRepository;
        $this->userCouponService = $userCouponService;
    }

    /**
     * @param int $userId
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public function storeProcess(int $userId, array $params) : array
    {
        $datingEncode = $params['dating_id'];
        $datingDecode = Utility::decode($datingEncode);
        $datingEntity = $this->datingRepository->getDatingById($datingDecode);
        $lastFeedBack = $this->feedbackRepository->getLastFeedbackOfUser($userId);
        $this->feedbackDomainService->handleStoreFeedback($datingEntity, $userId, $params);

        //last_satisfaction
        $lastSatisfaction = $params['last_satisfaction'];
        $user = $this->userRepository->getById($userId);

        // Send notification for user
        try {
            $key = $this->feedbackDomainService->getKeyForFeedbackNotification($lastSatisfaction, $user);
            if ($key) {
                $notification = $this->notificationRepository->getByKey($key);
                $this->notificationService->sendEmailNotificationToUser($user, $notification);
            }
        } catch (\Throwable $th) {
            Log::error($th, [
                'user_id' => $userId,
                'key' => $key,
            ]);
        }

        // Make user coupon
        $inviteeInvitation = $this->userInvitationRepository->retrieveUserInvitationByUserId($userId);
        if (empty($lastFeedBack) && $inviteeInvitation && !empty($inviteeInvitation->getPromotionCode())) {
            $userInvitationOfInviter = $this->userInvitationRepository->retrieveUserInvitationByInvitationCode($inviteeInvitation->getPromotionCode());
            if (!empty($userInvitationOfInviter)) {
                // check gender invitee complete feedback and store User Coupon
                $this->userCouponService->issueCoupon($user, $user->getGender() === UserGender::Male ? CouponType::Dating : CouponType::Bachelor);

                // store coupon for inviter
                $inviterInvitation = $this->userRepository->getById($userInvitationOfInviter->getUserId());
                if (!empty($inviterInvitation)) {
                    $this->userCouponService->issueCoupon($inviterInvitation, $inviterInvitation->getGender() === UserGender::Male ? CouponType::Dating : CouponType::Bachelor);
                }
            }
        }

        return [
            'message' => __('api_messages.userReview.successfully_created_new_user_review'),
            'data' => [],
            'status' => Response::HTTP_OK
        ];
    }

    /**
     * @param User $user
     * @param int|null $datingId
     * @return FeedbackService
     */
    public function isNeedGiveFeedbackBy(User $user, int $datingId = null): FeedbackService
    {
        $canGiveFeedback = $this->datingDomainService->isNeedGiveFeedbackBy($user->getId(), $datingId);

        if ($canGiveFeedback) {
            $this->message = __('api_messages.successful');
        } else {
            $this->message = __('api_messages.feedback.cant_send_feedback');
        }

        $this->data = ['canGiveFeedback' => $canGiveFeedback];
        return $this;
    }

    /**
     * Handle response api
     *
     * @return array
     */
    public function handleApiResponse(): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data
        ];
    }

    /**
     * @param User $user
     * @return array
     */
    public function getInfoGenerateFeedback(User $user, ?string $datingIdEncoded = null): array
    {
        $datingsNeedFeedback = $this->datingRepository->getDatingsNoFeedbackByUserId($user->getId(), DatingStatus::Completed);
        $datingsNeedFBArr = [];
        foreach ($datingsNeedFeedback as $dating) {
            array_push($datingsNeedFBArr, [
                'dating_id' => Utility::encode($dating->getId()),
                'dating_day' => $dating->getDatingDay()->getDatingDayOfWeekJa(),
                'dating_date' => $dating->getDatingDay()->getDatingDateJaFeedbackFormat()
            ]);
        }

        $data['review_data'] = $this->formatReviewBoxes($this->reviewBoxRepository->getReviewBoxes());
        $data['dating_need_feedback'] = $datingsNeedFBArr;
        if ($datingIdEncoded) {
            $datingIdDecoded = Utility::decode($datingIdEncoded);
            $datingDay = $this->datingRepository->getDatingById($datingIdDecoded)->getDatingDay();

            $data['dating_for_passed_id'] = [
                'dating_id_decoded' => $datingIdDecoded,
                'dating_day_of_week' => $datingDay->getDatingDayOfWeekJa(),
                'dating_date' => $datingDay->getDatingDateJaFormat()
            ];
        }

        return $data;
    }

    /**
     * get send feedback condition
     * @param User $user
     * @return array
     */
    public function getSendFeedbackCondition(User $user): array
    {
        $data = [];
        $datingNoFeedbacks = $this->datingRepository->getDatingsNoFeedbackByUserId($user->getId(), DatingStatus::Completed);
        $isAllFeedbackGiven = $datingNoFeedbacks->count() == 0;
        $data['isAllFeedbackGiven'] = $isAllFeedbackGiven;
        if ($isAllFeedbackGiven) {
            $feedback = $this->feedbackRepository->getLastFeedbackOfUser($user->getId());
            $data['lastSatisfaction'] = $feedback->getLastSatisfaction();
            $userPlan = $this->userPlanRepository->getActiveUserPlanByUserId($user->getId());
            if($userPlan) {
                $data['costPlan'] = $userPlan->getPlan()->getCostPlanKey();
            }
        } else {
            $data['datingId'] = Utility::encode($datingNoFeedbacks->first()->getId());
        }
        return $data;
    }
}

