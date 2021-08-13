<?php

namespace Bachelor\Application\Admin\EventHandler\Listeners\UserManagement;

use Bachelor\Application\Admin\EventHandler\Events\UserManagement\UserApprovedByAdmin;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Interfaces\NotificationRepositoryInterface;
use Bachelor\Domain\NotificationManagement\Notification\Services\NotificationService;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\UserProfile\Enums\UserProfile;
use Bachelor\Domain\UserManagement\UserProfile\Interfaces\UserProfileInterface;
use Illuminate\Support\Facades\Log;

class SendApprovedNotification
{
    /**
     * @var NotificationService
     */
    protected NotificationService $notificationService;

    /**
     * @var NotificationRepositoryInterface
     */
    protected NotificationRepositoryInterface $notificationRepository;

    /**
     * @var UserProfileInterface
     */
    protected UserProfileInterface $userProfileRepository;

    /**
     * @var ParticipantMainMatchRepositoryInterface
     */
    protected ParticipantMainMatchRepositoryInterface $participantMainMatchRepository;

    /**
     * RequestedCancellationNotification constructor.
     * @param NotificationService $notificationService
     * @param NotificationRepositoryInterface $notificationRepository
     */
    public function __construct(
        NotificationService $notificationService,
        NotificationRepositoryInterface $notificationRepository,
        UserProfileInterface $userProfileRepository,
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepository
    ) {
        $this->notificationRepository = $notificationRepository;
        $this->notificationService = $notificationService;
        $this->userProfileRepository = $userProfileRepository;
        $this->participantMainMatchRepository = $participantMainMatchRepository;
    }

    /**
     * @param UserApprovedByAdmin $event
     * @return void
     */
    public function handle(UserApprovedByAdmin $event) {
        $user = $event->getUser();

        // Todo: need to fix so it sends reapproval reactivaton notification in reactive/reapprove case
        $key = $user->getGender() == UserGender::Male
            ? config('notification_keys.approval_no_2nd_regisatration_male')
            : config('notification_keys.approval_no_2nd_regisatration_female');

        $notification = $this->notificationRepository->getByKey($key);

        if (! $notification) {
            Log::error('Notification is not found.', [
                'key' => $key
            ]);
            return;
        }

        $matchInfoUrl = $this->userProfileRepository->retrieveUserProfileByUserId(
            $user->getId(),
            [UserProfile::User]
        )->getMatchInfoUrl();

        $participants = $this->participantMainMatchRepository->getAwaitingForUser($user);
        $participantDatingDayStr = "";
        foreach ($participants as $participant) {
            /* @var ParticipantMainMatch $participant */
            $participantDatingDayStr = "- " . $participantDatingDayStr . $participant->getDatingDay()->getDatingDateJaFormat() . chr(10);
        }

        $notification->mapVariable('match_info_url_per_age', $matchInfoUrl);
        $notification->mapVariable('participated_date', $participantDatingDayStr);
        $this->notificationService->sendEmailNotificationToUser($user, $notification);
    }
}
