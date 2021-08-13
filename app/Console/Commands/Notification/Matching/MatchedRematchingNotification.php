<?php

namespace App\Console\Commands\Notification\Matching;

use App\Console\Commands\Notification\AbstractNotificationSenderCommand;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;

class MatchedRematchingNotification extends AbstractNotificationSenderCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:matched-rematching {gender}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notification for matched rematching on 13pm dating day';

    /**
     * @return string|null
     */
    protected function getKey(): ?string
    {
        if ($this->getEligibleGender() == UserGender::Female) {
            return config('notification_keys.matched_rematching_for_female');
        } elseif ($this->getEligibleGender() == UserGender::Male) {
            return config('notification_keys.matched_rematching_for_male');
        }

        return null;
    }
}
