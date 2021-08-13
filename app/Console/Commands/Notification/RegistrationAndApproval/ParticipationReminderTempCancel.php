<?php

namespace App\Console\Commands\Notification\RegistrationAndApproval;

use Illuminate\Console\Command;
use App\Console\Commands\Notification\AbstractNotificationSenderCommand;
use Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers\TempCancelTrialNoParticipantUsers;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;

class ParticipationReminderTempCancel extends AbstractNotificationSenderCommand
{
    /**
     * The name and signature of the console command.
     * 
     * @var string
     */
    protected $signature = 'registraion-approval-notification:participation-reminder-temp-cancel {gender}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification for participation reminder temp cancel users';

    /**
     * Create a new command instance.
     *
     * @return void 
     */
    public function __construct(
        NotificationRepositoryInterface $notificationRepository,
        NotificationService $notificationService,
        TempCancelTrialNoParticipantUsers $tempCancelTrialNoParticipantUsers
    ){
        $this->eligibleReceiver = $tempCancelTrialNoParticipantUsers;
        parent::__construct($notificationRepository, $notificationService);
    }

    /**
     * @return string
     */
    protected function getKey(): string
    {
        if ($this->getEligibleGender() == UserGender::Female) {
            return config('notification_keys.participation_reminder_tempcancel_female');
        } elseif ($this->getEligibleGender() == UserGender::Male) {
            return config('notification_keys.participation_reminder_tempcancel_male');
        }

        return null;           
    }
}
