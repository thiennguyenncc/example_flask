<?php

namespace App\Console\Commands\Notification\Participation;

use App\Console\Commands\Notification\AbstractNotificationSenderCommand;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;

/**
 * Runs on: monday 12pm
 * Runs for: users who have been approved and 2nd registration completed, and have no participation this week
 */
class ParticipationReminderHasNoParticipation extends AbstractNotificationSenderCommand
{
    /**
     * @var string
     */
    protected $signature = 'notification:participation_reminder_has_no_participation {gender=male}';

    /**
     * @var string
     */
    protected $description = 'Send notification for none participated users every week';

    /**
     * @return string|null
     */
    protected function getKey(): ?string
    {
        if ($this->getEligibleGender() == UserGender::Female) {
            return config('notification_keys.participation_reminder_has_no_participation_for_female_users');
        } elseif ($this->getEligibleGender() == UserGender::Male) {
            return config('notification_keys.participation_reminder_has_no_participation_for_male_users');
        }

        return null;
    }
}
