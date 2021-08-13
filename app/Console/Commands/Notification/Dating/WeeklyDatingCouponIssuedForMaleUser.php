<?php

namespace App\Console\Commands\Notification\Dating;

use App\Console\Commands\Notification\AbstractNotificationSenderCommand;

/**
 * Runs on: sunday 21pm
 * Runs for: male users who have been approved and in paid term, and have no dating this week
 */
class WeeklyDatingCouponIssuedForMaleUser extends AbstractNotificationSenderCommand
{
    /**
     * @var string
     */
    protected $signature = 'notification:weekly_dating_coupon_issued {gender=male}';

    /**
     * @var string
     */
    protected $description = 'Send notification for none participated paid male users every weekend';

    /**
     * @return string
     */
    protected function getKey(): string
    {
        return config('notification_keys.weekly_dating_coupon_issued_for_male_user');
    }
}
