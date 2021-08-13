<?php

namespace Bachelor\Application\User\EventHandler\Listeners\ParticipantMainMatch;

use Bachelor\Domain\Base\Exception\BaseValidationException;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Events\RequestedToParticipate;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\UserManagement\Registration\Enums\RegistrationSteps;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;

class ChangeToAwaitingForApproval
{
    private NotificationRepositoryInterface $notificationRepository;

    private NotificationService $notificationService;

    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        NotificationRepositoryInterface $notificationRepository,
        NotificationService $notificationService
    ) {
        $this->userRepository = $userRepository;
        $this->notificationRepository = $notificationRepository;
        $this->notificationService = $notificationService;
    }

    /**
     * @param RequestedToParticipate $event
     * @return void
     * @throws BaseValidationException
     */
    public function handle(RequestedToParticipate $event)
    {
        $user = $event->getUser();

        if ($user->getStatus() !== UserStatus::IncompleteUser
            || $user->getRegistrationSteps() !== RegistrationSteps::StepBefore1stParticipateMain
        ) {
            return; // not valid user then pass
        }

        // change status of user to Awaiting
        $user->setAwaiting();
        $this->userRepository->save($user);

        $key = $user->getGender() == UserGender::Male
                ? config('notification_keys.complete_1st_registation_male')
                : config('notification_keys.complete_1st_registation_female');

        $notification = $this->notificationRepository->getByKey($key);

        if (! $notification) {
            Log::error('Notification is not found.', [
                'key' => $key
            ]);
            return;
        }

        // send email to user
        $this->notificationService->sendEmailNotificationToUser($user, $notification);
    }
}
