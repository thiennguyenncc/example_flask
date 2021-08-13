<?php

namespace Bachelor\Domain\DatingManagement\ParticipantMainMatch\Services;

use Bachelor\Domain\Base\Exception\BaseValidationException;
use Bachelor\Domain\Base\Exception\BaseValidationMessages;
use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\DatingManagement\Dating\Services\DatingDomainService;
use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\DatingManagement\ParticipationOpenExpirySetting\Enums\ParticipationOpenExpireStatus;
use Bachelor\Domain\DatingManagement\ParticipationOpenExpirySetting\Interfaces\ParticipationOpenExpirySettingRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantAwaitingCancelSetting\Service\AwaitingCancelCalculatorService;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\AvailableFrequencies;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantMainValidationMessages;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ValidationMessages;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\Coupon\Emums\CouponType;
use Bachelor\Domain\MasterDataManagement\Coupon\Interfaces\CouponRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\Prefecture\Enums\ValidationMessages as PrefectureValidationMessages;
use Bachelor\Domain\MasterDataManagement\Prefecture\Interfaces\PrefectureRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Invoice\Interfaces\InvoiceRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Subscription\Enum\SubscriptionStatus;
use Bachelor\Domain\PaymentManagement\UserTrial\Enum\TrialStatus;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\SubscriptionRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Subscription\Models\Subscription;
use Bachelor\Domain\PaymentManagement\UserTrial\Interfaces\UserTrialRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\UserManagement\User\Enums\ValidationMessages as UserValidationMessages;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Domain\UserManagement\UserCoupon\Interfaces\UserCouponRepositoryInterface;
use Bachelor\Utility\Enums\Status;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ParticipantMainMatchValidatorService
{
    private ParticipantMainMatchRepositoryInterface $participantMainMatchRepository;

    private DatingDomainService $datingService;

    private DatingRepositoryInterface $datingRepository;

    private AwaitingCancelCalculatorService $awaitingCancelCalculatorService;

    private ParticipationOpenExpirySettingRepositoryInterface $participationOpenExpirySettingRepository;

    private InvoiceRepositoryInterface $invoiceRepository;

    private CouponRepositoryInterface $couponRepository;

    private UserCouponRepositoryInterface $userCouponRepository;

    private UserTrialRepositoryInterface $userTrialRepository;

    private SubscriptionRepositoryInterface $subscriptionRepository;

    private ParticipantMainMatchService $participantMainMatchService;

    private PrefectureRepositoryInterface $prefectureRepository;

    public function __construct(
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepository,
        DatingDomainService $datingService,
        DatingRepositoryInterface $datingRepository,
        AwaitingCancelCalculatorService $awaitingCancelCalculatorService,
        ParticipationOpenExpirySettingRepositoryInterface $participationOpenExpirySettingRepository,
        InvoiceRepositoryInterface $invoiceRepository,
        CouponRepositoryInterface $couponRepository,
        UserCouponRepositoryInterface $userCouponRepository,
        UserTrialRepositoryInterface $userTrialRepository,
        SubscriptionRepositoryInterface $subscriptionRepository,
        ParticipantMainMatchService $participantMainMatchService,
        PrefectureRepositoryInterface $prefectureRepository
    ) {
        $this->participantMainMatchRepository = $participantMainMatchRepository;
        $this->datingService = $datingService;
        $this->datingRepository = $datingRepository;
        $this->awaitingCancelCalculatorService = $awaitingCancelCalculatorService;
        $this->participationOpenExpirySettingRepository = $participationOpenExpirySettingRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->couponRepository = $couponRepository;
        $this->userCouponRepository = $userCouponRepository;
        $this->userTrialRepository = $userTrialRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->participantMainMatchService = $participantMainMatchService;
        $this->prefectureRepository = $prefectureRepository;
    }

    /**
     * @param User $user
     * @param Collection $requestedDays
     * @return bool
     * @throws \Exception
     */
    public function validate(User $user, Collection $requestedDays): bool
    {
        if (empty($user->getEmail())) {
            throw BaseValidationException::withMessages(ParticipantMainValidationMessages::UserEmailEmpty);
        }

        $prefecture = $this->prefectureRepository->getSpecificPrefecture($user->getPrefectureId());
        if ($prefecture->getStatus() == Status::Inactive) {
            throw BaseValidationException::withMessages(ParticipantMainValidationMessages::PrefectureDeactivated);
        }

        $participatedDays = $this->participantMainMatchRepository->getParticipatedHistoryForUser(
            $user,
            Carbon::now()->subWeeks(config('matching.max_weeks'))->startOfWeek()->toDateString()
        )->transform(function ($item) {
            /* @var ParticipantMainMatch $item */
            return $item->getDatingDay();
        });

        $datingCoupon = $this->couponRepository->getCouponByCouponType(CouponType::Dating);
        $userDatingCoupons = $this->userCouponRepository->getAllAvailableCoupon($user, $datingCoupon);
        $userTrial = $this->userTrialRepository->getLatestTrialByUser($user);
        $subscription = $this->subscriptionRepository->getLatestSubscription($user);
        $allPreCompletedDatings = $this->datingRepository->getDatingsByUserId($user->getId(), DatingStatus::Completed);
        $availableFrequency = $this->availableFrequency($user, $subscription);

        if (
            $availableFrequency == AvailableFrequencies::None ||
            ($availableFrequency == AvailableFrequencies::OncePerThreeWeeks && $participatedDays->count() > 0)
        ) {
            throw new \Exception(__('dating.no_participate_permission'));
        }
        if (
            $user->getGender() == UserGender::Male &&
                ((!$userTrial || $userTrial?->getStatus() == TrialStatus::Active) && $allPreCompletedDatings->count() >= 1) || // New male or trial can't participate if dating has completed
                ($userTrial?->getStatus() == TrialStatus::TempCancelled && $allPreCompletedDatings->count() >= 2) // Male tempCancelled due to "one more trial" request can participate even if one dating is completed
        ) {
            throw new \Exception(__('dating.no_participate_permission'));
        }
        if ($this->datingService->isNeedGiveFeedbackBy($user->getId())) {
            throw new \Exception(__('dating.need_send_feedback'));
        }
        if ($this->invoiceRepository->getAllUnpaidInvoicesWhichGracePeriodExpiredByUser($user)->count() > 0) {
            throw new \Exception(__('dating.need_resolve_invoice'));
        }
        if (!$this->checkIfDayIsAlreadyParticipated($requestedDays, $participatedDays)) {
            throw new \Exception(__('dating.date_is_already_participated'));
        }
        if (!$this->checkAwaitingCancel($user, $requestedDays)) {
            throw new \Exception(__('dating.date_full'));
        }
        if (!$this->checkIsAllDayOpened($user, $requestedDays)) {
            throw new \Exception(__('dating.date_closed'));
        }
        if ($availableFrequency == AvailableFrequencies::OncePerWeek) {
            $this->isCouponsEnoughEachWeek($userDatingCoupons, $requestedDays, $participatedDays);
        }
        return true;
    }

    /**
     * @param User $user
     * @return string
     */
    public function availableFrequency(User $user, ?Subscription $subscription): string
    {
        if ($user->getGender() == UserGender::Female) {
            return AvailableFrequencies::All;
        }

        if (
            $user->getGender() == UserGender::Male &&
            $user->getStatus() == UserStatus::ApprovedUser &&
            $subscription?->getStatus() == SubscriptionStatus::Active
        ) {
            return AvailableFrequencies::OncePerWeek;
        }

        return AvailableFrequencies::OncePerThreeWeeks;
    }

    /**
     * @param User $user
     * @param DatingDay $datingDay
     * @return bool
     */
    public function canUserParticipateOn(User $user, DatingDay $datingDay): bool
    {
        $datingDays = new Collection([$datingDay]);
        try {
            $this->checkAwaitingCancel($user, $datingDays);
            $this->checkIsAllDayOpened($user, $datingDays);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param User $user
     * @return string
     */
    private function getCurrentSubscriptionStatusOrTrialForUser(User $user): string
    {
        $subscription = $this->subscriptionRepository->getLatestSubscription($user);

        if ($subscription) return $subscription->getStatus();

        $userTrial = $this->userTrialRepository->getLatestTrialByUser($user);

        if ($userTrial && ($userTrial->getStatus() == TrialStatus::Active || $userTrial->getStatus() == TrialStatus::TempCancelled)) return 'Trial';

        return '';
    }

    /**
     * @param Collection $requestedDays
     * @param Collection $participatedDays
     * @return bool
     */
    private function checkIfDayIsAlreadyParticipated(Collection $requestedDays, Collection $participatedDays): bool
    {
        foreach ($requestedDays as $requestedDay) {
            foreach ($participatedDays as $participatedDay) {
                if ($requestedDay->getId() == $participatedDay->getId()) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * @throws \Exception
     */
    private function isCouponsEnoughEachWeek(Collection $coupons, Collection $requestedDays, Collection $participatedDays): void
    {
        if ($requestedDays->count() > 1 || $participatedDays->count() > 0) {
            $couponLeft = $coupons->count();

            foreach ($this->getRequestedDaysAndParticipatedDaysPerWeek($requestedDays, $participatedDays) as $weekDates) {
                // Weekly process coupon
                $requestedDaysCountInWeek = 0;
                $leftWeeklyDatingCountByPlan = 1; // Paid male user has 1 day free per week
                if (isset($weekDates['requested'])) {
                    $requestedDaysCountInWeek = count($weekDates['requested']);
                }
                if (isset($weekDates['participated'])) {
                    $leftWeeklyDatingCountByPlan = 0;
                }
                if ($requestedDaysCountInWeek > $couponLeft + $leftWeeklyDatingCountByPlan) {
                    throw new \Exception(__('dating.coupons_not_enough'));
                }
                if ($requestedDaysCountInWeek) {
                    $couponLeft -= ($requestedDaysCountInWeek - $leftWeeklyDatingCountByPlan);
                }
            }
        }
    }

    /**
     * @param Collection|DatingDay[] $requestedDays
     * @param Collection|DatingDay[] $participatedDays
     * @return array
     */
    private function getRequestedDaysAndParticipatedDaysPerWeek(Collection $requestedDays, Collection $participatedDays): array
    {
        $weeks = [];
        foreach ($requestedDays as $requestedDay) {
            $week = Carbon::createFromFormat('Y-m-d', $requestedDay->getDatingDate())->startOfWeek()->toDateString();
            $weeks[$week]['requested'][$requestedDay->getId()] = $requestedDay;
        }
        foreach ($participatedDays as $participatedDay) {
            $week = Carbon::createFromFormat('Y-m-d', $participatedDay->getDatingDate())->startOfWeek()->toDateString();
            $weeks[$week]['participated'][$participatedDay->getId()] = $participatedDay;
        }
        return $weeks;
    }

    /**
     * @param User $user
     * @param Collection $datingDays
     * @return bool
     */
    private function checkAwaitingCancel(User $user, Collection $datingDays): bool
    {
        foreach ($datingDays as $datingDay) {
            $currentRatio = $this->participantMainMatchService->getFemaleMaleRatio($user->getPrefectureId(), $datingDay);
            if ($this->awaitingCancelCalculatorService->isAwaitingCancel($user, $datingDay, $currentRatio)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param User $user
     * @param Collection|DatingDay[] $datingDays
     * @return bool
     */
    private function checkIsAllDayOpened(User $user, Collection $datingDays): bool
    {
        foreach ($datingDays as $datingDay) {
            $participationOpenExpirySetting = $this->participationOpenExpirySettingRepository->getDetail(
                $user->getGender(),
                $datingDay->getDatingDayOfWeek(),
                $user->getRegistrationCompleted()
            );

            if (
                $participationOpenExpirySetting->getOpenExpireStatusOn(
                    $datingDay->getDatingDate()
                ) != ParticipationOpenExpireStatus::Opened
            ) {
                return false;
            }
        }
        return true;
    }
}
