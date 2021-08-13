<?php

namespace App\Console\Commands\Notification\Participation;

use App\Console\Commands\Notification\AbstractNotificationSenderCommand;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Model\ParticipantMainMatch;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Models\Notification;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\PaymentManagement\UserTrial\Enum\TrialStatus;
use Bachelor\Domain\PaymentManagement\UserTrial\Interfaces\UserTrialRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Models\User;

/**
 * Runs on: monday 12pm
 * Runs for: users who have been approved and 2nd registration completed, and have participation this week
 */
class ParticipationReminderHasParticipation extends AbstractNotificationSenderCommand
{
    /**
     * @var ParticipantMainMatchRepositoryInterface
     */
    protected ParticipantMainMatchRepositoryInterface $participantMainMatchRepository;

    /**
     * @var UserTrialRepositoryInterface
     */
    protected UserTrialRepositoryInterface $userTrialRepository;

    /**
     * @var string
     */
    protected $signature = 'notification:participation_reminder_has_participation {gender=male}';

    /**
     * @var string
     */
    protected $description = 'Send notification for awaiting participated users every week';


    public function __construct(
        NotificationRepositoryInterface $notificationRepository,
        NotificationService $notificationService,
        UserTrialRepositoryInterface $userTrialRepository,
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepository
    ) {
        $this->userTrialRepository = $userTrialRepository;
        $this->participantMainMatchRepository = $participantMainMatchRepository;
        parent::__construct($notificationRepository, $notificationService);
    }


    /**
     * @return string|null
     */
    protected function getKey(): ?string
    {
        if ($this->getEligibleGender() == UserGender::Female) {
            return config('notification_keys.participation_reminder_has_participation_for_female_users');
        } elseif ($this->getEligibleGender() == UserGender::Male) {
            return config('notification_keys.participation_reminder_has_participation_for_male_users');
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
            /* @var ParticipantMainMatch[] $participants */
            $participants = $this->variableMapDatas[$user->getId()]['participants'];
            
            $mappedContent = '';
            foreach ($participants as $participant) {
                $mappedContent .= $participant->getDatingDay()->getDatingDateJaFormat() .
                '(' . $participant->getDatingDay()->getDatingDayOfWeek() . ')' . PHP_EOL;
            }
            $notification->mapVariable('dating_date_this_week_list', $mappedContent);

            $participationUrl = $this->variableMapDatas[$user->getId()]['participation_text'];
            $participationUrl ?? $notification->mapVariable('participation_text', $participationUrl);
        }
        parent::proceedSendingNotification($user, $notification);
    }

    /**
     * @return void
     */
    protected function addVariableMapDatas(): void
    {
        $userIds = $this->eligibleUsers->map(function ($user) {
            return $user->getId();
        })->toArray();

        $participants = $this->participantMainMatchRepository->getParticipantsByUserIds($userIds);
        $userTrials = $this->userTrialRepository->getByUserIds($userIds);

        $results = [];
        foreach ($this->eligibleUsers as $user) {
            $participantsForUser = $participants->filter(function ($participant) use ($user) {
                /* @var ParticipantMainMatch $participant */
                return $participant->getUserId() == $user->getId();
            });
            $trialForUser = $userTrials->filter(function ($userTrial) use ($user) {
                /* @var UserTrial $participant */
                return $userTrial->getUserId() == $user->getId() && $userTrial->getStatus == TrialStatus::Active;
            });

            $results[$user->getId()] = [
                'participants' => $participantsForUser,
                'participation_text' => $trialForUser->isNotEmpty() ? null : "【他の日もデート参加する】\n" . env('WEB_APP_URL') . "participation"
            ];
        }

        $this->variableMapDatas = $results;
    }
}
