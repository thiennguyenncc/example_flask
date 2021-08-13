<?php

namespace Bachelor\Application\User\EventHandler\Listeners\ParticipantMainMatch;

use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Events\ParticipantMainMatchCreated;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Events\RequestedToParticipate;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\UserPlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Interfaces\UserTrialRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Services\UserTrialService;
use Bachelor\Domain\UserManagement\UserProfile\Enums\UserProfile;
use Bachelor\Domain\UserManagement\UserProfile\Interfaces\UserProfileInterface;

class RestartTrialIfValidAndSendNotification
{
    private UserTrialRepositoryInterface $userTrialRepository;

    private NotificationRepositoryInterface $notificationRepository;

    private NotificationService $notificationService;

    private UserPlanRepositoryInterface $userPlanRepository;

    private UserTrialService $userTrialService;

    private UserProfileInterface $userProfileRepository;

    public function __construct(
        UserTrialRepositoryInterface $userTrialRepository,
        NotificationRepositoryInterface $notificationRepository,
        NotificationService $notificationService,
        UserPlanRepositoryInterface $userPlanRepository,
        UserTrialService $userTrialService,
        UserProfileInterface $userProfileRepository
    ) {
        $this->userTrialRepository = $userTrialRepository;
        $this->notificationRepository = $notificationRepository;
        $this->notificationService = $notificationService;
        $this->userPlanRepository = $userPlanRepository;
        $this->userTrialService = $userTrialService;
        $this->userProfileRepository = $userProfileRepository;
    }

    /**
     * @param ParticipantMainMatchCreated $event
     * @return void
     */
    public function handle(RequestedToParticipate $event)
    {
        $user = $event->getUser();
        $userTrial = $this->userTrialService->restartTrialIfValid($user);

        if (!$userTrial) {
            return; // not valid user then pass
        }

        if ($user->getRegistrationCompleted()) {
            $notification = $this->notificationRepository->getByKey(config('notification_keys.2nd_temp_cancel_2nd_registration_completed_for_male_user'));
            if ($notification) {
                $userPlan = $this->userPlanRepository->getActiveUserPlanByUserId($user->getId());
                $notification->mapVariable('trial_end', $userTrial->getJaTrialEnd());
                $notification->mapVariable('plan_name', $userPlan->getPlan()->getCostPlan()->getName());
                $notification->mapVariable('plan_pricing', $userPlan->getPlan()->getFinalAmount());
                $notification->mapVariable('p_pricing_per_date', $userPlan->getPlan()->getAmountPerDating());
                $this->notificationService->sendEmailNotificationToUser($user, $notification);
            }
        } else {
            $notification = $this->notificationRepository->getByKey(config('notification_keys.tempcancel_participated_no_2nd_registration_male'));
            
            if ($notification) {
                $matchInfoUrl = $this->userProfileRepository->retrieveUserProfileByUserId(
                    $user->getId(),
                    [UserProfile::User]
                )->getMatchInfoUrl();

                $notification->mapVariable('match_info_url_per_age', $matchInfoUrl);
                $this->notificationService->sendEmailNotificationToUser($user, $notification);
            }
        }
    }
}
