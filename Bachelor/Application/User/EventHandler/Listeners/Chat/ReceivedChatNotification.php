<?php

namespace Bachelor\Application\User\EventHandler\Listeners\Chat;

use Bachelor\Domain\Communication\Chat\Event\ChatReceived;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Utility\Helpers\Utility;
use Illuminate\Support\Facades\Log;

class ReceivedChatNotification
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
     * ReceivedChatNotification constructor.
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

    public function handle(ChatReceived $event)
    {
        try {
            /** @var User $user */
            $user = $event->receiverUser;
            $roomId = $event->roomId;

            if ($user->getGender() == UserGender::Male) {
                $key = config('notification_keys.chat_received_for_male_user');
            } else {
                $key = config('notification_keys.chat_received_for_female_user');
            }

            $notification = $this->notificationRepository->getByKey($key);
            $chatUrl = Utility::shortenUrl(config('constants.CHAT_URL') . Utility::encode($roomId));

            $notification->mapVariable('chat_url', $chatUrl);

            $this->notificationService->sendEmailNotificationToUser($user, $notification);
        } catch (\Throwable $th) {

            Log::error($th, [
                'user_id' => $user->getId(),
                'key' => $key,
            ]);
        }
    }
}
