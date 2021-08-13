<?php

namespace App\Console\Commands\Notification\Matching;

use App\Console\Commands\Notification\AbstractNotificationSenderCommand;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;

class MatchingChatOpenForFakeUsersNotification extends AbstractNotificationSenderCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:open-chat-for-fake {gender}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notification for open chat for fake users on one day before dating day 3pm';

    /**
     * @return string|null
     */
    protected function getKey(): ?string
    {
        if ($this->getEligibleGender() == UserGender::Female) {
            return config('notification_keys.matching_chat_open_for_fake_female_users');
        } elseif ($this->getEligibleGender() == UserGender::Male) {
            return config('notification_keys.matching_chat_open_for_fake_male_users');
        }

        return null;
    }
}
