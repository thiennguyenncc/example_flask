<?php
namespace Bachelor\Application\User\EventHandler\Listeners\PaymentCard;

use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\PaymentManagement\PaymentCard\Events\StoredNewCard;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\UserPlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Interfaces\UserTrialRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\Registration\Enums\RegistrationSteps;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;

class CompleteRegistrationStepIfValid
{
    /**
     * @var NotificationRepositoryInterface
     */
    protected NotificationRepositoryInterface $notificationRepository;

    /**
     * @var NotificationService
     */
    protected NotificationService $notificationService;

    /**
     * @var UserTrialRepositoryInterface
     */
    protected UserTrialRepositoryInterface $userTrialRepository;

    /**
     * @var ParticipantMainMatchRepositoryInterface
     */
    protected ParticipantMainMatchRepositoryInterface $participantMainMatchRepository;

    /**
     * @var UserPlanRepositoryInterface
     */
    protected UserPlanRepositoryInterface $userPlanRepository;

    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    public function __construct(
        NotificationRepositoryInterface $notificationRepository,
        NotificationService $notificationService,
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepository,
        UserTrialRepositoryInterface $userTrialRepository,
        UserPlanRepositoryInterface $userPlanRepository,
        UserRepositoryInterface $userRepository
    )
    {
        $this->notificationRepository = $notificationRepository;
        $this->notificationService = $notificationService;
        $this->participantMainMatchRepository = $participantMainMatchRepository;
        $this->userTrialRepository = $userTrialRepository;
        $this->userPlanRepository = $userPlanRepository;
        $this->userRepository = $userRepository;
    }

    public function handle(StoredNewCard $event)
    {
        $user = $event->user;

        if (
            $this->participantMainMatchRepository->getAwaitingForUser($user)->isEmpty()
            || $user->getRegistrationSteps() != RegistrationSteps::StepBeforeFinal
        ) {
            return;       
        }
        
        $user->setRegistrationSteps(RegistrationSteps::StepFinal);
        $this->userRepository->save($user);

        $key = $user->getGender() == UserGender::Male
            ? config('notification_keys.2nd_registration_complete_male')
            : config('notification_keys.2nd_registration_complete_female');

        $notification = $this->notificationRepository->getByKey($key);

        if (!$notification) {
            Log::error('Notification is not found.', [
                'key' => $key
            ]);
            return;
        }

        if ($user->getGender() == UserGender::Male) {
            $userTrial = $this->userTrialRepository->getLatestUserTrialByUserIfActive($user);
            $plan = $this->userPlanRepository->getActiveUserPlanByUserId($user->getId())?->getPlan();
            $notification->mapVariable('trial_end', $userTrial?->getJaTrialEnd());
            $notification->mapVariable('plan_name', $plan?->getCostPlan()->getName());
            $notification->mapVariable('plan_pricing', $plan?->getFinalAmount());
            $notification->mapVariable('p_pricing_per_date', $plan?->getAmountPerDating());
        }
        
        $this->notificationService->sendEmailNotificationToUser($user, $notification);
    }
}
