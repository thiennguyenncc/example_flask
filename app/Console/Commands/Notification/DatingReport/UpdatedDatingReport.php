<?php

namespace App\Console\Commands\Notification\DatingReport;

use App\Console\Commands\Notification\AbstractNotificationSenderCommand;
use Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers\DisplayDatingReportToday;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Carbon\Carbon;

class UpdatedDatingReport extends AbstractNotificationSenderCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:dating-report-updated {gender}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display to updated dating report on 9am Sunday for users on 9AM';

    public function __construct(
        NotificationRepositoryInterface $notificationRepository,
        NotificationService $notificationService,
        DisplayDatingReportToday $displayDatingReportToday
    ) {
        $this->eligibleReceiver = $displayDatingReportToday;

        parent::__construct($notificationRepository, $notificationService);
    }

    protected function getKey(): ?string
    {
        if ($this->getEligibleGender() == UserGender::Female) {
            return config('notification_keys.dating_report_updated_female_users');
        } elseif ($this->getEligibleGender() == UserGender::Male) {
            return config('notification_keys.dating_report_updated_male_users');
        }

        return null;
    }
}
