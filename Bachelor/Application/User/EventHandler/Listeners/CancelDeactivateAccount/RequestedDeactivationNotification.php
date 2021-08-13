<?php

namespace Bachelor\Application\User\EventHandler\Listeners\CancelDeactivateAccount;

use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\UserManagement\User\Events\SentDeactivationForm;
use Bachelor\Domain\UserManagement\User\Models\User;
use Illuminate\Support\Facades\Log;

class RequestedDeactivationNotification
{
    /**
     * @var NotificationService
     */
    protected NotificationService $notificationService;

    /**
     * @var NotificationRepositoryInterface
     */
    protected NotificationRepositoryInterface $notificationRepository;


    public function __construct(
        NotificationService $notificationService,
        NotificationRepositoryInterface $notificationRepository
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->notificationService = $notificationService;
    }

    public function handle(SentDeactivationForm $event)
    {
        /** @var User $user */
        $user = $event->user;

        if ($user->getGender() == UserGender::Male) {
            $key = config('notification_keys.deactivation_requested_for_male_user');
        } else {
            $key = config('notification_keys.deactivation_requested_for_female_user');
        }

        $notification = $this->notificationRepository->getByKey($key);
        if (!$notification || $user->getStatus() != UserStatus::DeactivatedUser) {
            Log::info('Notification is not found or not deactivated user.');
            return;
        }
        $this->notificationService->sendEmailNotificationToUser($user, $notification, true);
    }
}
