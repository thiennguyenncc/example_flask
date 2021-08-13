<?php

namespace App\Console\Commands\Notification\RegistrationAndApproval;

use App\Console\Commands\Notification\AbstractNotificationSenderCommand;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Services\ParticipantMainMatchService;
use Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers\ParticipateUsersBeforeLastDayOf2ndRegisterDeadline;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Models\Notification;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\UserManagement\User\Models\User;
use Carbon\Carbon;

class SecondReminderFor2ndRegistrationUsers extends AbstractNotificationSenderCommand
{
    /**
     * The name and signature of the console command.
     * 
     * @var string
     */
    protected $signature = 'registraion-approval-notification:second-reminder-for-2nd-registration-users {gender}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to remind second time 2nd registration users';

    /**
     * @var ParticipantMainMatchRepositoryInterface
     */
    protected ParticipantMainMatchRepositoryInterface $participantMainMatchRepository;

    /**
     * @var ParticipantMainMatchService
     */
    protected ParticipantMainMatchService $participantMainMatchService;

    /**
     * Create a new command instance.
     *
     * @return void 
     */
    public function __construct(
        NotificationRepositoryInterface $notificationRepository,
        NotificationService $notificationService,
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepository,
        ParticipantMainMatchService $participantMainMatchService,
        ParticipateUsersBeforeLastDayOf2ndRegisterDeadline $participateUsersIncompleted2ndRegisterBeforeLastDay
    ){
        $this->eligibleReceiver = $participateUsersIncompleted2ndRegisterBeforeLastDay;
        $this->participantMainMatchRepository = $participantMainMatchRepository;
        $this->participantMainMatchService = $participantMainMatchService;
        $this->eligibleReceiver->approvedDay = Carbon::today()->subDays(4);
        parent::__construct($notificationRepository, $notificationService);
    }

    /**
     * @return string
     */
    protected function getKey(): string
    {
        if ($this->getEligibleGender() == UserGender::Female) {
            return config('notification_keys.2nd_reminder_for_2nd_registration_female');
        } elseif ($this->getEligibleGender() == UserGender::Male) {
            return config('notification_keys.2nd_reminder_for_2nd_registration_male');
        }

        return null;            
    }

    /**
     * @param User $user
     * @param Notification $notification
     */
    protected function proceedSendingNotification(User $user, Notification $notification): void
    {
        if (isset($this->variableMapDatas[$user->getId()])) {
            $notification->mapVariable('deadline_day_of_week', $this->variableMapDatas[$user->getId()]);
        }
        parent::proceedSendingNotification($user, $notification);
    }

    /**
     * @return void
     */
    protected function addVariableMapDatas(): void
    {
        $userIds = $this->eligibleUsers->map(function (User $user) {
            return $user->getId();
        })->toArray();

        $participants = $this->participantMainMatchRepository->getParticipantsByUserIds($userIds);
        $oldestParticipantsPerUserId = $this->participantMainMatchService->getListForOldestDatingDayPerUserId($participants);

        foreach ($oldestParticipantsPerUserId as $userId => $participant) {
            $deadlineDayOfWeeks[$userId] = $participant->getParticipateDeadline()->isoFormat('ddd') . '曜';
        }

        $this->variableMapDatas = $deadlineDayOfWeeks;
    }
}
