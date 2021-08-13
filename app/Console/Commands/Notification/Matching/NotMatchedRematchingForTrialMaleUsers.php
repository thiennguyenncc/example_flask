<?php

namespace App\Console\Commands\Notification\Matching;

use App\Console\Commands\Notification\AbstractNotificationSenderCommand;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;

class NotMatchedRematchingForTrialMaleUsers extends AbstractNotificationSenderCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:not_matched_rematching_for_trial {gender=male}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notification for not matched rematching for male users on 13pm dating day';

    /**
     * @return string|null
     */
    protected function getKey(): ?string
    {
        if ($this->getEligibleGender() == UserGender::Male) {
            return config('notification_keys.not_matched_rematching_for_trial_male_users');
        }

        return null;
    }
}
