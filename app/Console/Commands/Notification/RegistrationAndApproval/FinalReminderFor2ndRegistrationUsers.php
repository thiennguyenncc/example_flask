<?php

namespace App\Console\Commands\Notification\RegistrationAndApproval;

use Illuminate\Console\Command;
use App\Console\Commands\Notification\AbstractNotificationSenderCommand;
use Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers\ParticipantUsersIncompleteRegisterDeadlineTomorrow;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;

class FinalReminderFor2ndRegistrationUsers extends AbstractNotificationSenderCommand
{
    /**
     * The name and signature of the console command.
     * 
     * @var string
     */
    protected $signature = 'registraion-approval-notification:final-reminder-for-2nd-registration-users {gender}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to remind final time 2nd registration users';

    /**
     * Create a new command instance.
     *
     * @return void 
     */
    public function __construct(
        NotificationRepositoryInterface $notificationRepository,
        NotificationService $notificationService,
        ParticipantUsersIncompleteRegisterDeadlineTomorrow $participantUsersIncompleteRegisterDeadlineTomorrow
    ){
        $this->eligibleReceiver = $participantUsersIncompleteRegisterDeadlineTomorrow;
        parent::__construct($notificationRepository, $notificationService);
    }

    /**
     * @return string
     */
    protected function getKey(): string
    {
        if ($this->getEligibleGender() == UserGender::Female) {
            return config('notification_keys.final_reminder_for_2nd_registration_female');
        } elseif ($this->getEligibleGender() == UserGender::Male) {
            return config('notification_keys.final_reminder_for_2nd_registration_male');
        }        
        
        return null;
    }
}
