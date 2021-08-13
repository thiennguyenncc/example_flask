<?php

namespace App\Console\Commands\Notification\Feedback;

use App\Console\Commands\Notification\AbstractNotificationSenderCommand;
use Bachelor\Domain\DatingManagement\Dating\Models\Dating;
use Bachelor\Domain\DatingManagement\Dating\Models\DatingUser;
use Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers\UserNoFillFeedbackLastDating;
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
 * Runs on: Friday 9:00pm
 * Runs for: users succeeded dating on last Wednesday and haven't filled feedback
 *
 */
class NoFillFeedbackLastDating extends AbstractNotificationSenderCommand
{
    /**
     * @var string
     */
    protected $signature = 'feedback-notification:no-fill-feedback-last-dating {gender}';

    /**
     * @var string
     */
    protected $description = 'Send feedback notification for users succeeded dating on last Wednesday and have not filled feedback';

    private DatingRepositoryInterface $datingRepository;

    public function __construct(
        NotificationRepositoryInterface $notificationRepository,
        NotificationService $notificationService,
        DatingRepositoryInterface $datingRepository,
        UserNoFillFeedbackLastDating $userNoFillFeedbackLastWeek
    ) {
        $this->datingRepository = $datingRepository;
        $this->eligibleReceiver = $userNoFillFeedbackLastWeek;

        if (Carbon::now()->isDayOfWeek(Carbon::FRIDAY)) {
            $this->eligibleReceiver->setFromDate(Carbon::now()->subDays(2)->startOfDay());
            $this->eligibleReceiver->setToDate(Carbon::now()->subDays(2)->endOfDay());
        } elseif (Carbon::now()->isDayOfWeek(Carbon::TUESDAY)) {
            $this->eligibleReceiver->setFromDate(Carbon::now()->subDays(3)->startOfDay());
            $this->eligibleReceiver->setToDate(Carbon::now()->subDays(2)->endOfDay());
        }

        parent::__construct($notificationRepository, $notificationService);
    }

    /**
     * @return string|null
     */
    protected function getKey(): ?string
    {
        if ($this->getEligibleGender() == UserGender::Female) {
            return config('notification_keys.notification_fill_wed_sat_sun_feedback_9pm_female');
        } elseif ($this->getEligibleGender() == UserGender::Male) {
            return config('notification_keys.notification_fill_wed_sat_sun_feedback_9pm_male');
        }

        return null;
    }

    /**
     * @param User $user
     * @param Notification $notification
     */
    protected function proceedSendingNotification(User $user, Notification $notification): void
    {
        $feedbackUrl = "";
        foreach ($this->variableMapDatas[$user->getId()] as $item) {
            $feedbackUrl .= $item . "\n";
        }

        $notification->mapVariable('feedback_url', $feedbackUrl);

        parent::proceedSendingNotification($user, $notification);

    }

    /**
     * @return array
     */
    protected function addVariableMapDatas(): void
    {
        $eligibleUserIds = CollectionHelper::convEntitiesToPropertyArray($this->eligibleUsers, UserProperty::Id);
        $datings = $this->datingRepository->getCompletedDatingWithoutFeedback($this->eligibleReceiver->getFromDate(), $this->eligibleReceiver->getToDate());
        $results = [];
        /** @var Dating $dating */
        foreach ($datings as $dating) {
            /** @var DatingUser $datingUser */
            foreach ($dating->getDatingUsers() as $datingUser) {
                foreach ($eligibleUserIds as $eligibleUserId) {
                    if ($eligibleUserId == $datingUser->getUserId()) {
                        $results[$eligibleUserId][] = $dating->getFeedbackUrl();
                        break;
                    }
                }
            }
        }

        $this->variableMapDatas = $results;
    }
}
