<?php

namespace App\Console\Commands\Notification\Matching;

use App\Console\Commands\Notification\AbstractNotificationSenderCommand;
use Bachelor\Domain\DatingManagement\DatingDay\Interfaces\DatingDayRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Models\Notification;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Models\User;
use Carbon\Carbon;

class RematchingReminderFemaleUsersNotification extends AbstractNotificationSenderCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:rematching_reminder {gender=female}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rematching reminder to female users on 9am one day before dating day';

    private DatingDayRepositoryInterface $datingDayRepository;

    public function __construct(NotificationRepositoryInterface $notificationRepository,
                                NotificationService $notificationService,
                                DatingDayRepositoryInterface $datingDayRepository
    ) {
        $this->datingDayRepository = $datingDayRepository;
        parent::__construct($notificationRepository,$notificationService);
    }
    /**
     * @return string|null
     */
    protected function getKey(): ?string
    {
        if ($this->getEligibleGender() == UserGender::Female) {
            return config('notification_keys.rematching_reminder_for_female_users');
        }

        return null;
    }

    protected function proceedSendingNotification(User $user, Notification $notification): void
    {
        $datingDay = $this->datingDayRepository->getByDate(Carbon::now()->toDateString());
        $notification->mapVariable('dating_day_id', $datingDay->getId());

        parent::proceedSendingNotification($user, $notification);
    }
}
