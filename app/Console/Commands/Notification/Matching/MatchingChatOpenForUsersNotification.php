<?php

namespace App\Console\Commands\Notification\Matching;

use App\Console\Commands\Notification\AbstractNotificationSenderCommand;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;

class MatchingChatOpenForUsersNotification extends AbstractNotificationSenderCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:chat-open {gender}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notification for open chat on one day before dating day 3pm';

    /**
     * @return string|null
     */
    protected function getKey(): ?string
    {
        if ($this->getEligibleGender() == UserGender::Female) {
            return config('notification_keys.matching_chat_open_for_female_users');
        } elseif ($this->getEligibleGender() == UserGender::Male) {
            return config('notification_keys.matching_chat_open_for_male_users');
        }

        return null;
    }
}
