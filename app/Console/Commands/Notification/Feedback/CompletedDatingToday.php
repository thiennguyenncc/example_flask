<?php

namespace App\Console\Commands\Notification\Feedback;

use App\Console\Commands\Notification\AbstractNotificationSenderCommand;
use Bachelor\Utility\Helpers\CollectionHelper;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\NotificationManagement\Notification\Models\Notification;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Domain\UserManagement\User\Enums\UserProperty;
use Carbon\Carbon;

/**
 * Runs on: 9:00pm Wed, Sat and Sun
 * Runs for: users who completed dating on Wed, Sat and Sun
 *
 */
class CompletedDatingToday extends AbstractNotificationSenderCommand
{
    /**
     * @var string
     */
    protected $signature = 'feedback-notification:completed-dating-today {gender}';

    /**
     * @var string
     */
    protected $description = 'Send feedback notification for users completed dating';

    private $datingRepository;

    public function __construct(
        NotificationRepositoryInterface $notificationRepository,
        NotificationService $notificationService,
        DatingRepositoryInterface $datingRepository
    ) {
        $this->datingRepository = $datingRepository;
        parent::__construct($notificationRepository, $notificationService);
    }

    /**
     * @return string|null
     */
    protected function getKey(): ?string
    {
        if (
            Carbon::now()->isDayOfWeek(Carbon::WEDNESDAY) ||
            Carbon::now()->isDayOfWeek(Carbon::SATURDAY) ||
            Carbon::now()->isDayOfWeek(Carbon::SUNDAY)
        ) {
            if ($this->getEligibleGender() == UserGender::Female) {
                return config('notification_keys.notification_completed_dating_female');
            } elseif ($this->getEligibleGender() == UserGender::Male) {
                return config('notification_keys.notification_completed_dating_male');
            }
        }

        return null;
    }

    /**
     * @param User $user
     * @param Notification $notification
     */
    protected function proceedSendingNotification(User $user, Notification $notification): void
    {
        $notification->mapVariable('feedback_url', $this->variableMapDatas[$user->getId()] ?? '');

        parent::proceedSendingNotification($user, $notification);
    }

    /**
     * @return array
     */
    protected function addVariableMapDatas(): void
    {
        $eligibleUserIds = CollectionHelper::convEntitiesToPropertyArray($this->eligibleUsers, UserProperty::Id);

        $datings = $this->datingRepository->getDatingsCompletedToday();

        $results = [];
        foreach ($datings as $dating) {
            foreach ($dating->getDatingUsers() as $datingUser) {
                foreach ($eligibleUserIds as $eligibleUserId) {
                    if ($eligibleUserId == $datingUser->getUserId()) {
                        $results[$eligibleUserId] = $dating->getFeedbackUrl();
                        break;
                    }
                }
            }
        }

        $this->variableMapDatas = $results;
    }
}
