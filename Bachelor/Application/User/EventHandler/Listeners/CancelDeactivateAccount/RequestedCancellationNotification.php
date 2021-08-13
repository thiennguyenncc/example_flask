<?php

namespace Bachelor\Application\User\EventHandler\Listeners\CancelDeactivateAccount;

use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\UserManagement\User\Events\SentCancellationForm;
use Bachelor\Domain\UserManagement\User\Models\User;
use Illuminate\Support\Facades\Log;

class RequestedCancellationNotification
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
     * RequestedCancellationNotification constructor.
     * @param NotificationService $notificationService
     * @param NotificationRepositoryInterface $notificationRepository
     */
    public function __construct(
        NotificationService $notificationService,
        NotificationRepositoryInterface $notificationRepository
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->notificationService = $notificationService;
    }

    public function handle(SentCancellationForm $event)
    {
        /* @var User $user */
        $user = $event->user;

        if ($user->getGender() == UserGender::Male) {
            $key = config('notification_keys.cancellation_requested_for_male_user');
        } else {
            $key = config('notification_keys.cancellation_requested_for_female_user');
        }


        $notification = $this->notificationRepository->getByKey($key);
        if (!$notification || $user->getStatus() != UserStatus::CancelledUser) {
            Log::info('Notification is not found or not cancelled user.');
            return;
        }
        $this->notificationService->sendEmailNotificationToUser($user, $notification, true);
    }
}
