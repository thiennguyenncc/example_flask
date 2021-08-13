<?php

namespace Bachelor\Application\User\Services;

use Bachelor\Application\User\Services\Interfaces\ParticipantMainMatchServiceInterface;
use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\DatingManagement\Dating\Services\DatingDomainService;
use Bachelor\Domain\DatingManagement\DatingDay\Interfaces\DatingDayRepositoryInterface;
use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\DatingManagement\ParticipantRecommendationSetting\Service\RecommendationCalculatorService;
use Bachelor\Domain\DatingManagement\ParticipationOpenExpirySetting\Interfaces\ParticipationOpenExpirySettingRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantAwaitingCancelSetting\Service\AwaitingCancelCalculatorService;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Events\RequestedToParticipate;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Model\ParticipantMainMatch;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Services\ParticipantMainMatchService as ParticipantMainMatchDomainService;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Services\ParticipantMainMatchValidatorService;
use Bachelor\Domain\MasterDataManagement\Prefecture\Interfaces\PrefectureRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Invoice\Services\InvoiceService;
use Bachelor\Domain\MasterDataManagement\Coupon\Emums\CouponType;
use Bachelor\Domain\MasterDataManagement\Coupon\Interfaces\CouponRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Invoice\Interfaces\InvoiceRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\SubscriptionRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Enum\TrialStatus;
use Bachelor\Domain\PaymentManagement\UserTrial\Interfaces\UserTrialRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Services\UserTrialService;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Domain\UserManagement\User\Services\UserDomainService;
use Bachelor\Domain\UserManagement\UserCoupon\Interfaces\UserCouponRepositoryInterface;
use Bachelor\Domain\UserManagement\UserCoupon\Services\UserCouponDomainService;
use Bachelor\Domain\UserManagement\UserInfoUpdatedTime\Interfaces\UserInfoUpdatedTimeInterface;
use Bachelor\Utility\Helpers\Utility;
use Exception;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;

class ParticipantMainMatchService implements ParticipantMainMatchServiceInterface
{
    private ParticipantMainMatchRepositoryInterface $participantMainMatchRepository;

    private DatingDayRepositoryInterface $datingDayRepository;

    private PrefectureRepositoryInterface $prefectureRepository;

    private UserRepositoryInterface $userRepository;

    private RecommendationCalculatorService $recommendationCalculatorService;

    /**
     * @var AwaitingCancelCalculatorService
     */
    private $awaitingCancelCalculatorService;

    /**
     * @var DatingDomainService
     */
    private $datingService;

    private UserDomainService $userDomainService;

    private ParticipationOpenExpirySettingRepositoryInterface $participationOpenExpirySettingRepository;

    private InvoiceService $invoiceService;

    private InvoiceRepositoryInterface $invoiceRepository;

    private ParticipantMainMatchDomainService $participantMainMatchService;

    /**
     * @var ParticipantMainMatchValidatorService
     */
    private $participantMainMatchValidatorService;

    /**
     * @var UserTrialService
     */
    private $userTrialService;

    /**
     * @var UserService
     */
    private $userService;

    private UserCouponRepositoryInterface $userCouponRepository;

    private UserCouponDomainService $userCouponService;

    private CouponRepositoryInterface $couponRepository;

    private UserInfoUpdatedTimeInterface $userInfoUpdatedTimeRepository;

    private UserTrialRepositoryInterface $userTrialRepository;

    private DatingRepositoryInterface $datingRepository;

    private SubscriptionRepositoryInterface $subscriptionRepository;

    /**
     * @var NotificationService
     */
    private $notificationService;

    /**
     * @var int
     */
    private $status;

    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $data = [];

    /**
     * ParticipantMainMatchService constructor.
     * @param ParticipantMainMatchRepositoryInterface $participantMainMatchRepository
     * @param DatingDayRepositoryInterface $datingDayRepository
     * @param RecommendationCalculatorService $recommendationCalculatorService
     * @param AwaitingCancelCalculatorService $awaitingCancelCalculatorService
     * @param UserTrialService $userTrialService
     * @param DatingDomainService $datingService
     * @param InvoiceRepositoryInterface $invoiceRepository
     * @param ParticipantMainMatchValidatorService $participantMainMatchValidatorService
     * @param ParticipantMainMatchDomainService $participantMainMatchService
     * @param UserService $userService
     * @param NotificationService $notificationService
     * @param UserCouponDomainService $userCouponService
     */
    public function __construct(
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepository,
        DatingDayRepositoryInterface $datingDayRepository,
        RecommendationCalculatorService $recommendationCalculatorService,
        AwaitingCancelCalculatorService $awaitingCancelCalculatorService,
        UserTrialService $userTrialService,
        DatingDomainService $datingService,
        UserDomainService $userDomainService,
        InvoiceService $invoiceService,
        ParticipationOpenExpirySettingRepositoryInterface $participationOpenExpirySettingRepository,
        InvoiceRepositoryInterface $invoiceRepository,
        ParticipantMainMatchValidatorService $participantMainMatchValidatorService,
        ParticipantMainMatchDomainService $participantMainMatchService,
        UserService $userService,
        NotificationService $notificationService,
        UserCouponRepositoryInterface $userCouponRepository,
        CouponRepositoryInterface $couponRepository,
        DatingRepositoryInterface $datingRepository,
        UserTrialRepositoryInterface $userTrialRepository,
        UserRepositoryInterface $userRepository,
        UserInfoUpdatedTimeInterface $userInfoUpdatedTimeRepository,
        SubscriptionRepositoryInterface $subscriptionRepository,
        UserCouponDomainService $userCouponService
    ) {
        $this->participantMainMatchService = $participantMainMatchService;
        $this->participantMainMatchRepository = $participantMainMatchRepository;
        $this->participantMainMatchValidatorService = $participantMainMatchValidatorService;
        $this->invoiceRepository = $invoiceRepository;
        $this->invoiceService = $invoiceService;
        $this->datingDayRepository = $datingDayRepository;
        $this->recommendationCalculatorService = $recommendationCalculatorService;
        $this->awaitingCancelCalculatorService = $awaitingCancelCalculatorService;
        $this->datingService = $datingService;
        $this->participationOpenExpirySettingRepository = $participationOpenExpirySettingRepository;
        $this->userTrialService = $userTrialService;
        $this->userService = $userService;
        $this->notificationService = $notificationService;
        $this->userRepository = $userRepository;
        $this->userTrialRepository = $userTrialRepository;
        $this->userCouponRepository = $userCouponRepository;
        $this->couponRepository = $couponRepository;
        $this->datingRepository = $datingRepository;
        $this->userInfoUpdatedTimeRepository = $userInfoUpdatedTimeRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->userCouponService = $userCouponService;

        $this->userDomainService = $userDomainService;
        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
    }

    /**
     * @param User $user
     * @return ParticipantMainMatchServiceInterface
     */
    public function getDatingDays(User $user): ParticipantMainMatchServiceInterface
    {
        $data = [];

        $subscription = $this->subscriptionRepository->getLatestSubscription($user);
        $availableFrequency = $this->participantMainMatchValidatorService->availableFrequency($user, $subscription);
        $datingCoupon = $this->couponRepository->getCouponByCouponType(CouponType::Dating);
        $userDatingCoupons = $this->userCouponRepository->getAllAvailableCoupon($user, $datingCoupon);
        $unpaidInvoicesWhichGraceExpired = $this->invoiceRepository->getAllUnpaidInvoicesWhichGracePeriodExpiredByUser($user);
        $lastUnPaidUrl = $unpaidInvoicesWhichGraceExpired->first() ? $unpaidInvoicesWhichGraceExpired->first()->getHostedInvoiceUrl() : '';
        $datingsNeedFeedback = $this->datingRepository->getDatingsNoFeedbackByUserId($user->getId(), DatingStatus::Completed);
        $datingsNeedFBArr = [];
        foreach ($datingsNeedFeedback as $dating) {
            array_push($datingsNeedFBArr, [
                'dating_id' => Utility::encode($dating->getId()),
                'dating_day' => $dating->getDatingDay()->getDatingDayOfWeekJa(),
                'dating_date' => $dating->getDatingDay()->getDatingDateJaFeedbackFormat()
            ]);
        }

        $data['user'] = $user->getId();
        $data['user_status'] = $user->getStatus();
        $data['registration_completed'] = $user->getRegistrationCompleted();
        $data['has_date_success'] = $this->datingRepository->hasCompletedDating($user);
        $data['dating_coupon_count'] = $userDatingCoupons->count();
        $data['participation_availability'] = $availableFrequency;
        $data['need_send_feedback'] = $this->datingService->isNeedGiveFeedbackBy($user->getId());
        $data['dating_need_feedback'] = $datingsNeedFBArr;
        $data['has_open_invoice'] = $unpaidInvoicesWhichGraceExpired->count() > 0;
        $data['last_invoice_url_unpaid'] = $lastUnPaidUrl;
        $data['weeks'] = $this->groupDatingDaysByWeek($user, config('matching.max_weeks'));

        $this->data = $data;

        return $this;
    }

    /**
     * @param User $user
     * @return ParticipantMainMatchServiceInterface
     */
    public function getAwaitingParticipantDatingDays(User $user): ParticipantMainMatchServiceInterface
    {
        $this->data = $this->participantMainMatchRepository->getAwaitingForUser($user)->transform(function (ParticipantMainMatch $item) use ($user) {
            /* @var ParticipantMainMatch $item */
            $result = [
                'id' => $item->getDatingDay()->getId(),
                'dating_day' => $item->getDatingDay()->getDatingDayOfWeek(),
                'dating_date' => $item->getDatingDay()->getDatingDate(),
            ];
            $result['used_bachelor_coupon'] = $this->userCouponService->usedBachelorCouponOnDatingDay($user, $item->getDatingDay());
            $result['matched'] = $item->getDatingDay()->getTimeRemaining();
            return $result;
        })->all();

        return $this;
    }

    /**
     * @param User $user
     * @param array $datingDayIds
     * @return ParticipantMainMatchServiceInterface
     * @throws Exception
     */
    public function requestToCancelSampleDates(User $user, array $datingDayIds): ParticipantMainMatchServiceInterface
    {
        $datingDays = $this->datingDayRepository->getByIds($datingDayIds);
        $this->participantMainMatchService->cancelByDays($user, $datingDays);

        foreach ($datingDays as $datingDay) {
            /** @var $datingDay DatingDay */
            if (!$this->invoiceService->createCancellationFeeInvoice(
                $user->getUserPaymentCustomer(),
                Carbon::make($datingDay->getDatingDate())->startOfDay(),
                Carbon::now()
            )) {
                throw new Exception(__('api_messages.failed_to_create_invoice'));
            }
        }

        $this->userTrialService->tempCancelIfValid($user);

        return $this;
    }

    /**
     * @param User $user
     * @param array $dateIds
     * @return ParticipantMainMatchServiceInterface
     * @throws Exception
     */
    public function requestToParticipate(User $user, array $dateIds): ParticipantMainMatchServiceInterface
    {
        $datingDays = $this->datingDayRepository->getByIds($dateIds);

        $this->participantMainMatchValidatorService->validate($user, $datingDays);

        $participatedDays = $this->participantMainMatchRepository->getParticipatedHistoryForUser(
            $user,
            Carbon::now()->subWeeks(config('matching.max_weeks'))->startOfWeek()->toDateString()
        )->transform(function ($item) {
            /* @var ParticipantMainMatch $item */
            return $item->getDatingDay();
        });

        $this->participantMainMatchService->participate($user, $datingDays);

        if ($user->getStatus() < UserStatus::ApprovedUser) {
            $userInfoUpdateTime = $this->userInfoUpdatedTimeRepository->retrieveUserInfoUpdatedTimeByUserId($user->getId());
            $userInfoUpdateTime->setFirstRegistrationCompletedAt(Carbon::now());
            $this->userInfoUpdatedTimeRepository->save($userInfoUpdateTime);
        }

        RequestedToParticipate::dispatch($user);

        $subscription = $this->subscriptionRepository->getAppliedSubscription($user);
        $userTrial = $this->userTrialRepository->getLatestTrialByUser($user);

        $this->data = [
            'user_status' => $user->getStatus(),
            'user_email' => $user->getEmail(),
            'trial_status_or_paid' => $user->getTrialStatusOrPaid($subscription, $userTrial),
            'trial_end' => $userTrial?->getStatus() === TrialStatus::Active ? $userTrial->getTrialEnd() : '',
            'registration_completed' => $user->getRegistrationCompleted(),
            'had_participation_before' => $participatedDays->isNotEmpty()
        ];

        return $this;
    }

    /**
     * @param User $user
     * @param array $dateIds
     * @return ParticipantMainMatchServiceInterface
     * @throws \Exception
     */
    public function requestToCancel(User $user, array $dateIds): ParticipantMainMatchServiceInterface
    {
        $datingDays = $this->datingDayRepository->getByIds($dateIds);

        $this->participantMainMatchService->cancelByDays($user, $datingDays);

        // if gender of user = male => update UserTrial
        if ($user->getGender() == UserGender::Male) {
            $this->userTrialService->tempCancelIfValid($user);
        }

        // if status of user = 2 => update status
        if ($user->getStatus() == UserStatus::AwaitingUser) {
            $this->userDomainService->setUserStatusToIncomplete($user);
        }

        return $this;
    }

    /**
     * @param User $user
     * @param int $numOfWeek
     * @return array
     */
    private function groupDatingDaysByWeek(User $user, int $numOfWeek): array
    {
        $weekStartDate = Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString();
        $participatedHistory = $this->participantMainMatchRepository->getParticipatedHistoryForUser($user, $weekStartDate);

        $weeks = [];
        for ($i = 0; $i < $numOfWeek; $i++) {
            $weekEndDate = Carbon::parse($weekStartDate)->startOfWeek()->addWeeks(1)->toDateString();
            $datingDays = $this->datingDayRepository->getRange($weekStartDate, $weekEndDate);

            $datingDays = $this->formatDatingDays($user, $datingDays, $participatedHistory);

            $weeks[$i] = $datingDays;
            $weekStartDate = $weekEndDate;
        }

        return $weeks;
    }

    /**
     * @param User $user
     * @param Collection $datingDayCollection
     * @param Collection $participatedHistory
     * @return array
     */
    private function formatDatingDays(User $user, Collection $datingDayCollection, Collection $participatedHistory): array
    {
        $participationDatingDays = [];
        foreach ($datingDayCollection as $datingDay) {
            $participationOpenExpirySetting = $this->participationOpenExpirySettingRepository->getDetail(
                $user->getGender(),
                $datingDay->getDatingDayOfWeek(),
                $user->getRegistrationCompleted()
            );

            $participationDatingDay = [];
            $participationDatingDay['id'] = $datingDay->getId();
            $participationDatingDay['dating_day'] = $datingDay->getDatingDayOfWeek();
            $participationDatingDay['dating_date'] = $datingDay->getDatingDate();
            $participationDatingDay['dating_day_label'] = ucfirst($datingDay->getDatingDayOfWeek());
            $participationDatingDay['time_remaining'] = Carbon::now()->diffInSeconds($participationOpenExpirySetting->getExpireDate($datingDay->getDatingDate()), false);
            $participationDatingDay['is_participated'] = $participatedHistory->contains(function ($item) use ($datingDay) {
                /* @var ParticipantMainMatch $item */
                return $item->getDatingDayId() == $datingDay->getId();
            });
            $participationDatingDay['show_sample_date'] = $participatedHistory->contains(function ($item) use ($datingDay) {
                /* @var ParticipantMainMatch $item */
                return $item->getDatingDayId() == $datingDay->getId() && $item->isShowSampleDate();
            });
            $participationDatingDay['available_after'] = $participationOpenExpirySetting->getOpenDate($datingDay->getDatingDate())->toDateTimeString();
            $participationDatingDay['open_expiry_status'] = $participationOpenExpirySetting->getOpenExpireStatusOn($datingDay->getDatingDate());

            $currentRatio = $this->participantMainMatchService->getFemaleMaleRatio($user->getPrefectureId(), $datingDay);

            $participationDatingDay['recommendation'] = $this->recommendationCalculatorService->isRecommend($user, $datingDay, $currentRatio);
            $participationDatingDay['awaiting_cancel'] = $this->awaitingCancelCalculatorService->isAwaitingCancel($user, $datingDay, $currentRatio);
            $participationDatingDays[] = $participationDatingDay;
        }

        return $participationDatingDays;
    }

    /**
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
}
