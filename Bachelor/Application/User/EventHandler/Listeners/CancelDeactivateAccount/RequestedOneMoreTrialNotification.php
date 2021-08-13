<?php

namespace Bachelor\Application\User\EventHandler\Listeners\CancelDeactivateAccount;

use Bachelor\Application\User\Services\Interfaces\NotificationServiceInterface;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\UserManagement\User\Events\SentOneMoreTrialRequest;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Log;

class RequestedOneMoreTrialNotification
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

    public function handle(SentOneMoreTrialRequest $event)
    {
        $user = $event->user;

        $key = config('notification_keys.one_more_trial_requested_for_male_user');
        $notification = $this->notificationRepository->getByKey($key);
        if (!$notification) {
            Log::info('Notification is not found.');
            return;
        }
        $this->notificationService->sendEmailNotificationToUser($user, $notification);
    }
}
