<?php

namespace Bachelor\Application\User\Services;

use Bachelor\Application\User\Services\Interfaces\DatingApplicationServiceInterface;
use Bachelor\Domain\Base\TimeSetting\Services\TimeSettingService;
use Bachelor\Domain\Communication\Chat\Services\ChatService as ChatDomainService;
use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\DatingManagement\Dating\Models\Dating;
use Bachelor\Domain\DatingManagement\Dating\Event\DatingCancelledAfterRematch;
use Bachelor\Domain\DatingManagement\Dating\Event\CancelledByPartner;
use Bachelor\Domain\DatingManagement\Dating\Event\CancelledByPartnerNoRematch;
use Bachelor\Domain\DatingManagement\Dating\Event\DatingCancelled;
use Bachelor\Domain\DatingManagement\Dating\Event\PartnerCancelledBeforeRematch;
use Bachelor\Domain\DatingManagement\Dating\Event\DatingCancelledBeforeRematch;
use Bachelor\Domain\DatingManagement\Dating\Services\DatingDomainService;
use Bachelor\Domain\DatingManagement\DatingDay\Interfaces\DatingDayRepositoryInterface;
use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Enums\ParticipantForRematchStatus;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Interfaces\ParticipantForRematchRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Models\ParticipantForRematch;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Services\ParticipantForRematchDomainService;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantsStatus;
use Bachelor\Domain\MasterDataManagement\RegisterOption\Enums\ProfileBodyType;
use Bachelor\Domain\PaymentManagement\Invoice\Services\InvoiceService;
use Bachelor\Domain\UserManagement\User\Enums\EducationType;
use Bachelor\Domain\UserManagement\UserCoupon\Interfaces\UserCouponRepositoryInterface;
use Bachelor\Domain\UserManagement\UserCoupon\Services\UserCouponDomainService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Model\ParticipantMainMatch;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Interfaces\DatingPlaceRepositoryInterface;
use Bachelor\Domain\MasterDataManagement\TrainStation\Interfaces\TrainStationRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Plan\Enum\CostPlan;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\UserPlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Services\UserTrialService;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Domain\UserManagement\User\Traits\MatchProfileFormatter;
use Bachelor\Domain\UserManagement\UserPreference\Interfaces\UserPreferenceInterface;
use Bachelor\Domain\UserManagement\UserProfile\Enums\UserProfile;
use Bachelor\Domain\UserManagement\UserProfile\Interfaces\UserProfileInterface;
use Bachelor\Port\Secondary\Database\UserManagement\Registration\Interfaces\EloquentRegisterOptionInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use stdClass;

class DatingApplicationService implements DatingApplicationServiceInterface
{
    use MatchProfileFormatter;

    /**
     * @var DatingRepositoryInterface
     */
    private $datingRepository;

    /**
     * @var DatingDomainService
     */
    private $datingDomainService;

    /**
     * @var DatingDayRepositoryInterface
     */
    private $datingDayRepository;

    /**
     * @var TimeSettingService
     */
    private $timeSetting;

    /**
     * @var UserProfileInterface
     */
    private $userProfileRepository;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var EloquentRegisterOptionInterface
     */
    private $registerOption;

    /**
     * @var UserPlanRepositoryInterface
     */
    private $userPlanRepository;

    /**
     * @var UserCouponDomainService
     */
    private $userCouponService;

    /**
     * @var ChatDomainService
     */
    private $chatService;

    /**
     * @var ParticipantMainMatchRepositoryInterface
     */
    private $participantMainMatchRepository;

    /**
     * @var UserPreferenceInterface
     */
    private $userPreferenceRepository;

    /**
     * @var InvoiceService
     */
    private $invoiceService;

    /**
     * @var ParticipantForRematchRepositoryInterface
     */
    private $participantForRematchRepository;

    /**
     * @var ParticipantForRematchDomainService
     */
    private $participantForRematchDomainService;

    /**
     * @var UserTrialService
     */
    private $userTrialService;

    /**
     * @var DatingPlaceRepositoryInterface
     */

    private DatingPlaceRepositoryInterface $datingPlaceRepository;
    /**
     * @var TrainStationRepositoryInterface
     */

    private TrainStationRepositoryInterface $trainStationRepository;
    /**
     * @var UserCouponRepositoryInterface
     */

    private UserCouponRepositoryInterface $userCouponRepository;

    /**
     * @var int
     */

    private $status;

    /**
     * @var string
     */
    private $message;

    /*
     * @var array
     */
    private $data = [];

    public function __construct(
        DatingRepositoryInterface $datingRepository,
        DatingDomainService $datingDomainService,
        DatingDayRepositoryInterface $datingDayRepository,
        TimeSettingService $timeSetting,
        UserProfileInterface $userProfileRepository,
        UserRepositoryInterface $userRepository,
        EloquentRegisterOptionInterface $registerOption,
        UserPlanRepositoryInterface $userPlanRepository,
        UserCouponDomainService $userCouponService,
        ChatDomainService $chatService,
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepository,
        UserPreferenceInterface $userPreferenceRepository,
        UserTrialService $userTrialService,
        InvoiceService $invoiceService,
        ParticipantForRematchRepositoryInterface  $participantForRematchRepository,
        ParticipantForRematchDomainService $participantForRematchDomainService,
        DatingPlaceRepositoryInterface $datingPlaceRepository,
        TrainStationRepositoryInterface $trainStationRepository,
        UserCouponRepositoryInterface $userCouponRepository
    ) {
        $this->datingRepository = $datingRepository;
        $this->datingDomainService = $datingDomainService;
        $this->datingDayRepository = $datingDayRepository;
        $this->timeSetting = $timeSetting;
        $this->userProfileRepository = $userProfileRepository;
        $this->userRepository = $userRepository;
        $this->registerOption = $registerOption;
        $this->userPlanRepository = $userPlanRepository;
        $this->userCouponService = $userCouponService;
        $this->chatService = $chatService;
        $this->participantMainMatchRepository = $participantMainMatchRepository;
        $this->userPreferenceRepository = $userPreferenceRepository;
        $this->invoiceService = $invoiceService;
        $this->participantForRematchRepository = $participantForRematchRepository;
        $this->userTrialService = $userTrialService;
        $this->participantForRematchDomainService = $participantForRematchDomainService;
        $this->datingPlaceRepository = $datingPlaceRepository;
        $this->trainStationRepository = $trainStationRepository;
        $this->userCouponRepository = $userCouponRepository;

        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
    }

    /**
     * Get match profile
     *
     * @return array
     */
    public function getMatchProfile(): array
    {
        $user = Auth::user()->getDomainEntity();
        $datingDays = $this->datingDayRepository->getRange(
            Carbon::now()->startOfWeek()->toDateString(),
            Carbon::now()->endOfWeek()->addWeeks(config('constants.displayable_weeks'))->toDateString(),
        );

        $weeks = [];
        $datingDays->each(function (DatingDay $datingDay) use (&$weeks, &$user) {
            $date = $datingDay->getDatingDate();
            $weekDiff = Carbon::now()->startOfWeek()->diffInWeeks(Carbon::parse($date));
            $dayOfWeek = ucfirst($datingDay->getDatingDayOfWeek());
            //get participate Main Matching
            $participateMainMatch = $this->participantMainMatchRepository->getLatestByUserAndDay($user, $datingDay);
            $dating = $this->datingRepository->getDatingByUserAndDatingDay($user, $datingDay);
            $participateRematch = $this->participantForRematchRepository->getByUserAndDatingDay($user, $datingDay);
            $bachelorCouponApplied = $this->userCouponService->usedBachelorCouponOnDatingDay($user, $datingDay);
            if ((!$participateMainMatch && !$participateRematch && !$dating)
                || $dating?->getStatus() === DatingStatus::Completed
            ) {
                return;
            }
            $weeks[$weekDiff][$dayOfWeek] = $this->formatMatchProfileItemData(
                $user,
                $participateMainMatch,
                $participateRematch,
                $datingDay,
                $dating,
                $bachelorCouponApplied
            );
        });
        $this->data = [
            'weeks' => $weeks,
            "current_server_time" => Carbon::now()->toDateTimeString(),
            "charge" => $this->getCharges(),
        ];

        return $this->handleApiResponse();
    }

    /**
     * Get match profile
     *
     * @return array
     */
    public function getMatchProfileDetail(int $datingId): array
    {
        $user = Auth::user()->getDomainEntity();
        //get dating
        $dating = $this->datingRepository->getDatingById($datingId, DatingStatus::Incompleted);
        $datingDay = $dating->getDatingDay();
        $partner = $this->userRepository->getById($dating->getPartnerDatingUserByUser($user)->getUserId());
        $partnerDetail = $this->getPartnerDetail($partner);
        $partnerDetail->show_crown = $this->showCrownOrNot($user, $partner, $datingDay);
        $partnerDetail->priorityPreference = $this->getPriorityPreferenceData($user, $partner, $datingDay);
        $datingPlace = $this->datingPlaceRepository->getById($dating->getDatingPlaceId());
        $trainStation = $this->trainStationRepository->findById($datingPlace->getTrainStationId());
        //get real data after implementing Dating Place
        $datingPlace = [
            'time' => $dating->getStartAt(),
            'day' => ucfirst($datingDay->getDatingDayOfWeek()),
            'date' => Carbon::parse($datingDay->getDatingDate())->format("m/d"),
            'phone' => $datingPlace->getPhone(),
            'name' => $datingPlace->getDatingPlaceTranslation()->getName(),
            'nearest_station' => $trainStation->getDefaultTrainStationTranslation()->getName(),
            'address' => $datingPlace->getDatingPlaceTranslation()->getDisplayAddress(),
            'rating' => $datingPlace->getRating(),
            'image' => $datingPlace->getImage(),
            'latitude' => $datingPlace->getLatitude(),
            'longitude' => $datingPlace->getLongitude(),
            'reference_page_link' => $datingPlace->getReferencePageLink(),
        ];

        $this->data = [
            'partner_detail' => $partnerDetail,
            'dating_place' => $datingPlace,
            "current_server_time" => Carbon::now(),
            "charge" => $this->getCharges()
        ];

        return $this->handleApiResponse();
    }

    /**
     *  Get charges
     */
    public function getCharges(): object
    {
        $charge = new stdClass();
        $charge->before_dating_date = config('constants.cancel_charge_not_free_day');
        $charge->on_dating_date = config('constants.cancel_charge_on_date_day');
        $charge->no_shown = config('constants.cancel_charge_for_partner_did_not_show_up');
        $charge->currency = config('constants.currency_symbol');

        return $charge;
    }

    /**
     * User request to cancel participate
     *
     * @param array $params = [
     *      'reasonForCancellation' => 'string',
     *      'detailedReason' => 'string',
     *      'datingId' => 'string',
     * ]
     * @return array
     */
    public function cancelDating(array $params): array
    {
        $user = Auth::user()->getDomainEntity();
        //cancel dating
        $dating = $this->datingDomainService->cancelDating($user, $params['datingId'], $params);
        if ($dating) {
            $partner = $this->userRepository->getById($dating->getPartnerDatingUserByUser($user)->getUserId());
            if (Carbon::now()->isBefore($dating->getDatingDay()->getRematchingTime())) {
                // join partner to 12pm rematching when it's before 12pm at dating day
                try {
                    if ($this->participantForRematchDomainService->validateParticipateForRematch($partner, $dating->getDatingDay())) {
                        $this->participantForRematchDomainService->participateForRematch($partner, $dating->getDatingDay());
                    }
                    PartnerCancelledBeforeRematch::dispatch($partner);
                } catch (\Throwable $th) {
                    Log::error($th, [
                        'user_id' => $user->getId(),
                        'dating_id' => $dating->getId()
                    ]);
                }
            } else {
                DatingCancelledAfterRematch::dispatch($partner, $dating->getDatingDay());
            }
            DatingCancelled::dispatch($user);
        }


        if (!$this->invoiceService->createCancellationFeeInvoice(
            $user->getUserPaymentCustomer(),
            Carbon::make($dating->getDatingDay()->getDatingDate())->startOfDay(),
            Carbon::now()
        )) {
            throw new \Exception(__('api_messages.failed_to_create_invoice'));
        }

        return $this->handleApiResponse();
    }

    /**
     * Cancelled Dating by partner
     *
     * @param array $params = [
     *      'datingId' => 'string',
     *      'requestRematching' => 'string',
     * ]
     * @return array
     */
    public function cancelledByPartner(array $params): array
    {
        $user = Auth::user()->getDomainEntity();

        //cancel dating by partner
        $dating = $this->datingDomainService->cancelledByPartner($user, $params['datingId']);

        $partnerIdDatingUser = $dating->getPartnerDatingUserByUser($user)->getUserId();
        $partner = $this->userRepository->getById($partnerIdDatingUser);

        if (!$params['requestRematching']) {
            CancelledByPartnerNoRematch::dispatch($user);
        }

        //create cancellation fee invoice
        $paidCancelFee = $this->invoiceService->createCancellationFeeInvoice(
            $partner->getUserPaymentCustomer(),
            Carbon::make($dating->getDatingDay()->getDatingDate())->startOfDay(),
            Carbon::now()
        );
        if (!$paidCancelFee) {
            throw new \Exception(__('api_messages.invoice.failed_to_create_invoice'));
        }

        PartnerCancelledBeforeRematch::dispatchIf(Carbon::now()->lt($dating->getDatingDay()->getRematchingTime()), $user);
        CancelledByPartner::dispatch($partner);

        return $this->handleApiResponse();
    }

    public function getPartnerSummary(User $partner): object
    {
        $partnerProfile = $this->userProfileRepository->retrieveUserProfileByUserId($partner->getId());

        $partnerSummary = new stdClass();
        $partnerSummary->id = $partner->getId();
        $partnerSummary->gender = $partner->getGender();
        $partnerSummary->age = $partnerProfile->getAge();
        $partnerSummary->job = $this->registerOption->getRegisterOptionDisplayName(
            $partnerProfile->getJob(),
            UserProfile::Job
        );

        return $partnerSummary;
    }

    public function getPartnerDetail(User $partner): object
    {
        $partnerProfile = $this->userProfileRepository->retrieveUserProfileByUserId($partner->getId());
        $partnerDetail = new stdClass();
        $partnerDetail->id = $partner->getId();
        $partnerDetail->gender = $partner->getGender();
        $partnerDetail->age = $partnerProfile->getAge();
        $partnerDetail->job = $this->registerOption->getRegisterOptionDisplayName(
            $partnerProfile->getJob(),
            UserProfile::Job
        );
        $partnerDetail->income = $this->registerOption->getRegisterOptionDisplayName(
            $partnerProfile->getAnnualIncome(),
            UserProfile::AnnualIncome
        );

        //because we don't want to show other always for Education = 4 & 99 then we need to handle this case directly in here
        if ($partnerProfile->getSchool()?->getSchoolName() !== null && $partnerProfile->getEducation() != EducationType::HighSchoolGraduation && $partnerProfile->getEducation() != EducationType::Other) {
            $partnerDetail->graduation = $partnerProfile->getSchool()->getSchoolName();
        } else {
            $partnerDetail->graduation = $this->registerOption->getRegisterOptionDisplayName(
                EducationType::Other,
                UserProfile::Education
            );
        }
        $partnerDetail->height = $partnerProfile->getHeight();

        $partnerDetail->body_shape = $this->registerOption->getRegisterOptionDisplayName(
            $partnerProfile->getBodyType(),
            UserProfile::PartnerBodyType,
            $partner->getGender()
        );
        $partnerDetail->appearance_strength = $this->registerOption->getRegisterOptionDisplayNames(
            $partnerProfile->getAppearanceStrength(),
            UserProfile::AppearanceStrength
        );
        $partnerDetail->hobby = $this->registerOption->getRegisterOptionDisplayNames(
            $partnerProfile->getHobby(),
            UserProfile::Hobby
        );
        $partnerDetail->personality = $this->registerOption->getRegisterOptionDisplayNames(
            $partnerProfile->getCharacter(),
            UserProfile::Character
        );
        $partnerDetail->bachelor_rate = $partner->getBRate();


        return $partnerDetail;
    }

    /**
     * Get priority preferences
     *
     * @param User $user
     * @param UserProfile $partnerProfile
     * @return array
     */
    protected function getPriorityPreferenceData(User $user, User $partner): array
    {
        $userPreference = $this->userPreferenceRepository->retrieveUserPreferenceByUserId($user->getId());
        $partnerProfile = $this->userProfileRepository->retrieveUserProfileByUserId($partner->getId());


        $priorities = [];
        $priorities['first'] = $userPreference->getFirstPriority();
        $priorities['second'] = $userPreference->getSecondPriority();
        $priorities['third'] = $userPreference->getThirdPriority();

        $priorityDisplayMatch = [];
        foreach ($priorities as $rank => $priority) {
            $result = $this->getMatchedPreference($priority, $user, $userPreference, $partnerProfile);
            if ($result) {
                $priorityDisplayMatch[$rank] = __('api_messages.matched_preference.' . $result['key'] . '.' . $partner->getGender(), $result['data']);
            } else {
                $priorityDisplayMatch[$rank] = "";
            }
        }

        return $priorityDisplayMatch;
    }

    /**
     * @param User $user
     * @param User $partner
     * @param DatingDay $datingDay
     * @return bool
     */
    public function showCrownOrNot(User $user, User $partner, DatingDay $datingDay)
    {
        //male user has premium plan
        $maleUser = $user->getGender() === UserGender::Male ? $user : $partner;
        $maleUserCostPlan = $this->userPlanRepository->getActiveUserPlanByUserId($maleUser->getId())->getPlan()->getCostPlanKey();
        if ($user->getGender() == UserGender::Male && $maleUserCostPlan === CostPlan::Premium && $partner->getBRate() >= config('constants.border_of_b_rate_to_show_crown')) {
            return true;
        }

        if($user->getGender() === UserGender::Female && $maleUserCostPlan === CostPlan::Premium){
            return true;
        }

        $usedBachelorCoupon = $this->userCouponService->usedBachelorCouponOnDatingDay($user, $datingDay);

        //user used bachelor coupon and partner's bachelor rate is
        if (
            $user->getGender() === UserGender::Male
            && $usedBachelorCoupon
            && $partner->getBRate() >= config('constants.border_of_b_rate_to_show_crown')
        ) {
            return true;
        }

        return false;
    }

    /**
     * Cancel all dating with fake users
     *
     * @param int $datingDayId
     */
    public function cancelAllFakeDatings(int $datingDayId)
    {
        $fakeUsers = $this->userRepository->retrieveFakeFemaleUsers();

        if ($fakeUsers->isNotEmpty()) {

            $fakeUsers->each(function ($fakeUser) use ($datingDayId) {

                $datings = $this->datingRepository->getDatingsByUserId($fakeUser->getId(), DatingStatus::Incompleted, $datingDayId);
                $datings->each(function ($dating) use ($fakeUser, $datingDayId) {

                    try {
                        if ($this->datingDomainService->cancelDating($fakeUser, $dating->getId())) {

                            $partner = $this->userRepository->getById($dating->getPartnerDatingUserByUser($fakeUser)->getUserId());

                            if ($this->participantForRematchDomainService->validateParticipateForRematch($partner, $dating->getDatingDay())) {

                                $this->participantForRematchDomainService->participateForRematch($partner, $dating->getDatingDay());
                            }

                            PartnerCancelledBeforeRematch::dispatchIf(Carbon::now()->lt($dating->getDatingDay()->getRematchingTime()), $partner);
                        }
                    } catch (\Throwable $th) {
                        Log::error($th, [
                            'dating_day_id' => $datingDayId,
                            'fake_female_id' => $fakeUser->getId(),
                            'dating_id' => $dating->getId()
                        ]);
                    }

                    // Log
                    Log::channel('dating')->info('Cancelled fake dating', [
                        'dating_day_id' => $datingDayId,
                        'fake_female_id' => $fakeUser->getId(),
                        'dating_id' => $dating->getId()
                    ]);
                });
            });
        }

        return $this;
    }

    /**
     * Return correct format information in match profile
     * @param User $user
     * @param ?ParticipantMainMatch $participateMainMatch
     * @param ?ParticipantForRematch $participateRematch
     * @param DatingDay $datingDay
     * @param ?Dating $dating
     * @param boolean $bachelorCouponApplied
     * @return array
     * @throws \Exception
     */
    private function formatMatchProfileItemData(
        User $user,
        ?ParticipantMainMatch $participateMainMatch,
        ?ParticipantForRematch $participateRematch,
        DatingDay $datingDay,
        ?Dating $dating,
        bool $bachelorCouponApplied
    ): array {
        $datingDate = Carbon::parse($datingDay->getDatingDate());
        if ($dating) {
            //get chat information
            switch ($dating->getStatus()) {
                case DatingStatus::Incompleted:
                    $partnerUser = $dating->getPartnerDatingUserByUser($user)->getUser();
                    $chatRoom = $this->chatService->getRoomByUserId($user->getId(), $partnerUser->getId());
                    $unreadCount = $this->chatService->getUnreadMessageNumber($user->getId(), $chatRoom['data']);
                    $showChatButton = $datingDay->isChatAble();
                    $partnerProfile = $this->userProfileRepository->retrieveUserProfileByUserId($partnerUser->getId());
                    $partnerJobLabel = $this->registerOption->getRegisterOptionDisplayName(
                        $partnerProfile->getJob(),
                        UserProfile::Job
                    );
                    $partnerEducationLabel = $this->registerOption->getRegisterOptionDisplayName(
                        $partnerProfile->getEducation(),
                        UserProfile::Education
                    );
                    return [
                        'datetime_type' => config('matchprofile_style.datetime_type.CLEAR_GRAY'),
                        'datetime_text' => $datingDate->format("m/d (D)") . $dating->getStartAt() . '~',
                        'description_type' => $showChatButton ? config('matchprofile_style.description_type.CHAT_BUTTON') : config('matchprofile_style.description_type.PARTNER_DETAIL'),
                        'description_text' => $partnerProfile->getAge() . '歳, ' . $partnerJobLabel,
                        'surrounding_ribbon_type' => NULL,
                        'chat_id' => $chatRoom['data'],
                        'unread_count' => $unreadCount,
                        'dating_id' => $dating->getId(),
                        'partner_id' => $partnerUser->getId(),
                        'show_crown' => $this->showCrownOrNot($user, $partnerUser, $dating->getDatingDay()),
                        'used_bachelor_coupon' => $bachelorCouponApplied,
                        'dating_day_id' => $datingDay->getId(),
                        'day' => $datingDay->getDatingDayOfWeek(),
                        'partner_bachelor_rate' => $partnerUser->getBRate()
                    ];
                case DatingStatus::Cancelled:
                    if ($participateRematch) {
                        switch ($participateRematch->getStatus()) {
                            case ParticipantForRematchStatus::Awaiting:
                                return [
                                    'datetime_type' => config('matchprofile_style.datetime_type.DARK_GRAY'),
                                    'datetime_text' => $datingDate->format("m/d (D)"),
                                    'description_type' => config('matchprofile_style.description_type.PARTNER_CANCELLED'),
                                    'description_text' => [
                                        'お相手を探しています',
                                        'キャンセルしたい>'
                                    ],
                                    'surrounding_ribbon_type' => NULL,
                                    'show_crown' => false,
                                    'used_bachelor_coupon' => $bachelorCouponApplied,
                                    'dating_day_id' => $datingDay->getId(),
                                    'day' => $datingDay->getDatingDayOfWeek()
                                ];
                            case ParticipantForRematchStatus::Unmatched:
                            case ParticipantForRematchStatus::Matched:
                            case ParticipantForRematchStatus::Cancelled:
                                return [
                                    'datetime_type' => config('matchprofile_style.datetime_type.DARK_GRAY'),
                                    'datetime_text' => $datingDate->format("m/d (D)"),
                                    'description_type' => config('matchprofile_style.description_type.DATE_CANCELLED'),
                                    'description_text' => [
                                        'デートはキャンセル',
                                        'されました'
                                    ],
                                    'surrounding_ribbon_type' => NULL,
                                    'show_crown' => false,
                                    'used_bachelor_coupon' => $bachelorCouponApplied,
                                    'dating_day_id' => $datingDay->getId(),
                                    'day' => $datingDay->getDatingDayOfWeek()
                                ];
                        }
                    } else {
                        return [
                            'datetime_type' => config('matchprofile_style.datetime_type.DARK_GRAY'),
                            'datetime_text' => $datingDate->format("m/d (D)"),
                            'description_type' => config('matchprofile_style.description_type.DATE_CANCELLED'),
                            'description_text' => [
                                'デートはキャンセル',
                                'されました'
                            ],
                            'surrounding_ribbon_type' => NULL,
                            'show_crown' => false,
                            'used_bachelor_coupon' => $bachelorCouponApplied,
                            'dating_day_id' => $datingDay->getId(),
                            'day' => $datingDay->getDatingDayOfWeek()
                        ];
                    }
                default:
                    return [];
            }
        } else {
            $timeDatingDefault = config('constants.default_dating_time_string.' . App::getLocale());
            if ($participateMainMatch) {
                switch ($participateMainMatch->getStatus()) {
                    case ParticipantsStatus::Awaiting:
                        if ($participateMainMatch->isShowSampleDate()) {
                            if ($user->getRegistrationCompleted()) {
                                return [
                                    'datetime_type' => config('matchprofile_style.datetime_type.CLEAR_GRAY'),
                                    'datetime_text' => $datingDate->format("m/d (D)") . $timeDatingDefault . '~',
                                    'description_type' => config('matchprofile_style.description_type.SAMPLE_DATE'),
                                    'description_text' => NULL,
                                    'surrounding_ribbon_type' => config('matchprofile_style.surrounding_ribbon_type.DATING_CONFIRM'),
                                    'show_crown' => false,
                                    'used_bachelor_coupon' => $bachelorCouponApplied,
                                    'dating_day_id' => $datingDay->getId(),
                                    'day' => $datingDay->getDatingDayOfWeek()
                                ];
                            } else {
                                return [
                                    'datetime_type' => config('matchprofile_style.datetime_type.CLEAR_GRAY'),
                                    'datetime_text' => $datingDate->format("m/d (D)") . $timeDatingDefault . '~',
                                    'description_type' => config('matchprofile_style.description_type.CONFIRM_BUTTON'),
                                    'description_text' => NULL,
                                    'surrounding_ribbon_type' => NULL,
                                    'show_crown' => false,
                                    'used_bachelor_coupon' => $bachelorCouponApplied,
                                    'dating_day_id' => $datingDay->getId(),
                                    'day' => $datingDay->getDatingDayOfWeek()
                                ];
                            }
                        } else {
                            return [
                                'datetime_type' => config('matchprofile_style.datetime_type.CLEAR_GRAY'),
                                'datetime_text' => $datingDate->format("m/d (D)") . $timeDatingDefault . '~',
                                'description_type' => config('matchprofile_style.description_type.AWAITING_MATCHING'),
                                'description_text' => 'マッチング待ち',
                                'surrounding_ribbon_type' => NULL,
                                'show_crown' => false,
                                'used_bachelor_coupon' => $bachelorCouponApplied,
                                'dating_day_id' => $datingDay->getId(),
                                'day' => $datingDay->getDatingDayOfWeek()
                            ];
                        }
                    case ParticipantsStatus::Unmatched:
                        if (!$participateRematch) {
                            return  [];
                        } else {
                            switch ($participateRematch->getStatus()) {
                                case ParticipantForRematchStatus::Awaiting:
                                    return [
                                        'datetime_type' => config('matchprofile_style.datetime_type.DARK_GRAY'),
                                        'datetime_text' => $datingDate->format("m/d (D)"),
                                        'description_type' => config('matchprofile_style.description_type.AWAITING_RE_MATCHING'),
                                        'description_text' => 'マッチング申請中',
                                        'surrounding_ribbon_type' => NULL,
                                        'show_crown' => false,
                                        'used_bachelor_coupon' => $bachelorCouponApplied,
                                        'dating_day_id' => $datingDay->getId(),
                                        'day' => $datingDay->getDatingDayOfWeek()
                                    ];
                                case ParticipantForRematchStatus::Cancelled:
                                    return [
                                        'datetime_type' => config('matchprofile_style.datetime_type.DARK_GRAY'),
                                        'datetime_text' => $datingDate->format("m/d (D)"),
                                        'description_type' => config('matchprofile_style.description_type.DATE_CANCELLED'),
                                        'description_text' => [
                                            'デートはキャンセル',
                                            'されました'
                                        ],
                                        'surrounding_ribbon_type' => NULL,
                                        'show_crown' => false,
                                        'used_bachelor_coupon' => $bachelorCouponApplied,
                                        'dating_day_id' => $datingDay->getId(),
                                        'day' => $datingDay->getDatingDayOfWeek()
                                    ];
                                case ParticipantForRematchStatus::Unmatched:
                                default:
                                    return [];
                            }
                        }
                        break;
                    default:
                        return [];
                }
            }else{
                return [];
            }
        }
    }

    /**
     * Format Registration data
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
}
