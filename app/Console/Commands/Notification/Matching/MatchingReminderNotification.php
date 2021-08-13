<?php

namespace App\Console\Commands\Notification\Matching;

use App\Console\Commands\Notification\AbstractNotificationSenderCommand;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;

class MatchingReminderNotification extends AbstractNotificationSenderCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:matching_reminder {gender}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Matching reminder on 9am one day before dating day';

    /**
     * @return string|null
     */
    protected function getKey(): ?string
    {
        if ($this->getEligibleGender() == UserGender::Female) {
            return config('notification_keys.matching_reminder_for_female_users');
        } elseif ($this->getEligibleGender() == UserGender::Male) {
            return config('notification_keys.matching_reminder_for_male_users');
        }

        return null;
    }
}
