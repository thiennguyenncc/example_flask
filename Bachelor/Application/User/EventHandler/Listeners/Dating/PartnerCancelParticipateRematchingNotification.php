<?php

namespace Bachelor\Application\User\EventHandler\Listeners\Dating;

use Bachelor\Domain\DatingManagement\Dating\Event\PartnerCancelledBeforeRematch;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Utility\Helpers\Log;

class PartnerCancelParticipateRematchingNotification
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
     * PartnerCancelParticipateRematchingNotification constructor.
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

    public function handle(PartnerCancelledBeforeRematch $event)
    {
        /** @var User $user */
        $user = $event->user;
        if ($user->getGender() == UserGender::Male) {
            $key = config('notification_keys.partner_cancel_participate_rematching_for_male_user');
        } else {
            $key = config('notification_keys.partner_cancel_participate_rematching_for_female_user');
        }
        $notification = $this->notificationRepository->getByKey($key);
        if (!$notification) {
            Log::info('Notification with ' . $key . ' is not exist.');
            return;
        }
        $this->notificationService->sendEmailNotificationToUser($user, $notification);
    }
}
