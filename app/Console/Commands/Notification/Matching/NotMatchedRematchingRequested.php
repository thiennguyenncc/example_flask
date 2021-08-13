<?php

namespace App\Console\Commands\Notification\Matching;

use App\Console\Commands\Notification\AbstractNotificationSenderCommand;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;

class NotMatchedRematchingRequested extends AbstractNotificationSenderCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:rematching_requested_not_matched {gender=female}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rematching requested not matched for female on 13pm dating day';

    /**
     * @return string|null
     */
    protected function getKey(): ?string
    {
        if ($this->getEligibleGender() == UserGender::Female) {
            return config('notification_keys.rematching_requested_not_matched_for_female_users');
        }

        return null;
    }
}
