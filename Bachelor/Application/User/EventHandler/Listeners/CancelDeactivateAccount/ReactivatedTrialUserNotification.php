<?php

namespace Bachelor\Application\User\EventHandler\Listeners\CancelDeactivateAccount;

use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\UserPlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Interfaces\UserTrialRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Events\GetReactivatedTrialMaleUser;
use Bachelor\Domain\UserManagement\User\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ReactivatedTrialUserNotification
{
    /**
     * @var NotificationService
     */
    protected NotificationService $notificationService;

    /**
     * @var NotificationRepositoryInterface
     */
    protected NotificationRepositoryInterface $notificationRepository;

    /**
     * @var UserPlanRepositoryInterface
     */
    protected UserPlanRepositoryInterface $userPlanRepository;

    /**
     * @var UserTrialRepositoryInterface
     */
    protected UserTrialRepositoryInterface $userTrialRepository;

    /**
     * ReactivatedTrialUserNotification constructor.
     * @param NotificationService $notificationService
     * @param NotificationRepositoryInterface $notificationRepository
     * @param UserPlanRepositoryInterface $userPlanRepository
     * @param UserTrialRepositoryInterface $userTrialRepository
     */
    public function __construct(
        NotificationService $notificationService,
        NotificationRepositoryInterface $notificationRepository,
        UserPlanRepositoryInterface $userPlanRepository,
        UserTrialRepositoryInterface $userTrialRepository
    )
    {
        $this->notificationRepository = $notificationRepository;
        $this->notificationService = $notificationService;
        $this->userPlanRepository = $userPlanRepository;
        $this->userTrialRepository =$userTrialRepository;
    }

    public function handle(GetReactivatedTrialMaleUser $event)
    {
        /** @var User $user */
        $user = $event->user;

        if ($user->getGender() != UserGender::Male) {
            Log::info('Notification is not found.');
            return;
        }
        $key = config('notification_keys.reactivated_trial_for_male_user');

        $notification = $this->notificationRepository->getByKey($key);

        if (! $notification) {
            return;
        }
        $userPlan = $this->userPlanRepository->getActiveUserPlanByUserId($user->getId());
        $userTrial = $this->userTrialRepository->getLatestTrialByUser($user);
        $notification->mapVariable('trial_start', $userTrial->getJaTrialStart());
        $notification->mapVariable('trial_end', $userTrial->getJaTrialEnd());
        $notification->mapVariable('plan_name', $userPlan->getPlan()->getCostPlan()->getName());
        $notification->mapVariable('plan_pricing', $userPlan->getPlan()->getFinalAmount());
        $this->notificationService->sendEmailNotificationToUser($user, $notification);
    }
}
