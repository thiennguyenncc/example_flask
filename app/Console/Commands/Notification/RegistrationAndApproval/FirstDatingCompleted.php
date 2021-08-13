<?php

namespace App\Console\Commands\Notification\RegistrationAndApproval;

use Illuminate\Console\Command;
use App\Console\Commands\Notification\AbstractNotificationSenderCommand;
use Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers\FirstDatingCompletedUsers;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Illuminate\Support\Facades\Log;

class FirstDatingCompleted extends AbstractNotificationSenderCommand
{
    /**
     * The name and signature of the console command.
     * 
     * @var string
     */
    protected $signature = 'registraion-approval-notification:first-dating-completed {gender=female}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification for first dating completed female as official approved';

    /**
     * Create a new command instance.
     *
     * @return void 
     */
    public function __construct(
        NotificationRepositoryInterface $notificationRepository,
        NotificationService $notificationService,
        FirstDatingCompletedUsers $firstDatingCompletedUsers
    ){
        $this->eligibleReceiver = $firstDatingCompletedUsers;
        parent::__construct($notificationRepository, $notificationService);
    }

    /**
     * @return string
     */
    protected function getKey(): string
    {
        if ($this->getEligibleGender() == UserGender::Female) {
            return config('notification_keys.1st_participation_complete_female');
        }
        
        return null;
    }
}
