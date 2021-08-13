<?php

namespace Bachelor\Domain\NotificationManagement\Notification\Services;

use Bachelor\Domain\NotificationManagement\Email\Enums\EmailStatus;
use Bachelor\Domain\NotificationManagement\Email\Interfaces\NotificationEmailMessageRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Email\Models\NotificationEmailMessage;
use Bachelor\Domain\NotificationManagement\Notification\Models\Notification;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\UserManagement\User\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    private NotificationEmailMessageRepositoryInterface $notificationEmailMessageRepository;

    public function __construct(NotificationEmailMessageRepositoryInterface $notificationEmailMessageRepository)
    {
        $this->notificationEmailMessageRepository = $notificationEmailMessageRepository;
    }

    /**
     * @param User $user
     * @param Notification $notification
     */
    public function sendEmailNotificationToUser(User $user, Notification $notification, bool $allowCancelledOrDeactivated = false): void
    {
        try {
            if (is_null($notification->getContent())) return;
            if (!$allowCancelledOrDeactivated && in_array(
                $user->getStatus(),
                [UserStatus::DeactivatedUser, UserStatus::CancelledUser]
            )) {
                Log::error('Cancelled or Deactivated user is not allwed to receive this notification', [
                    'user_id' => $user->getId(),
                    'notification_id' => $notification->getId(),
                ]);
    
                return;
            }
    
            $notificationEmailMessage = new NotificationEmailMessage(
                $user->getId(),
                $notification->getKey(),
                $notification->generateTitle(),
                $notification->generateContent(),
                EmailStatus::Processing,
                $notification->getId()
            );
            $this->notificationEmailMessageRepository->save($notificationEmailMessage)->setUser($user);
            $this->notificationEmailMessageRepository->send($notificationEmailMessage)->setStatus(EmailStatus::Success);
            $this->notificationEmailMessageRepository->save($notificationEmailMessage);
        } catch (\Throwable $th) {
            Log::error($th, [
                'user_id' => $user->getId(),
                'notification_id' => $notification->getId(),
            ]);

            return;
        }
    }

    public function past3SecAfterLastRead(int $notificationEmailId): bool
    {
        $previousNotificationRead = $this->notificationEmailMessageRepository->getUserLastReadAtByNotificationEmailId($notificationEmailId);

        if($previousNotificationRead)
        {
            $totalDuration = Carbon::now()->diffInSeconds($previousNotificationRead->getReadAt()->toDateTimeString());

            if($totalDuration <= 3)
                return false;
        }

        return true;
    }
}
