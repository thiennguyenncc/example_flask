<?php

namespace App\Console\Commands\Notification\Matching;

use App\Console\Commands\Notification\AbstractNotificationSenderCommand;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;

class NotMatchedForFeMaleUsersInMainMatchingNotification extends AbstractNotificationSenderCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:not-matched-main-matching {gender=female}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notification for not matched female users in main matching on one day before dating day 9am';

    /**
     * @return string|null
     */
    protected function getKey(): ?string
    {
        if ($this->getEligibleGender() == UserGender::Female) {
            return config('notification_keys.not_matched_for_female_users_in_main_matching');
        }

        return null;
    }
}
