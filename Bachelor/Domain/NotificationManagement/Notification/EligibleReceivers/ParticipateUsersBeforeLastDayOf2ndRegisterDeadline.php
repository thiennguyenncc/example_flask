<?php

namespace Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers;

use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantMainMatchProperty;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantsStatus;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Model\ParticipantMainMatch;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Services\ParticipantMainMatchService;
use Bachelor\Domain\UserManagement\UserInfoUpdatedTime\Enums\UserInfoUpdatedTimeProperty;
use Bachelor\Domain\UserManagement\UserInfoUpdatedTime\Interfaces\UserInfoUpdatedTimeInterface;
use Carbon\Carbon;

class ParticipateUsersBeforeLastDayOf2ndRegisterDeadline extends AbstractEligibleReceiver
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var ParticipantMainMatchRepositoryInterface
     */
    protected $participantMainMatchRepository;

    /**
     * @var UserInfoUpdatedTimeInterface
     */
    protected $userInfoUpdatedTimeRepository;

    /**
     * @var ParticipantMainMatchService
     */
    protected $participantMainMatchService;

    /**
     * @var Carbon
     */
    public Carbon $approvedDay;
    
    /**
     * AutoCancelParticipationUsers constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepository,
        UserInfoUpdatedTimeInterface $userInfoUpdatedTimeRepository,
        ParticipantMainMatchService $participantMainMatchService
    )
    {
        $this->userRepository = $userRepository;
        $this->participantMainMatchRepository = $participantMainMatchRepository;
        $this->userInfoUpdatedTimeRepository = $userInfoUpdatedTimeRepository;
        $this->participantMainMatchService = $participantMainMatchService;
    }

    public function retrieve(): Collection
    {
        $userInfoUpdatedTimes = $this->userInfoUpdatedTimeRepository->getOnSameDayForTime(
            UserInfoUpdatedTimeProperty::ApprovedAt, $this->approvedDay, [UserInfoUpdatedTimeProperty::User]
        );

        $timesOfUserApprovedRegistIncompleted = $userInfoUpdatedTimes->filter(function ($time) {
            $user = $time->getUser();

            return $user->getStatus() === UserStatus::ApprovedUser
                && !$user->getRegistrationCompleted();
        });

        $userIds = $timesOfUserApprovedRegistIncompleted->map(function ($time) {
            return $time->getUser()->getId();
        })->toArray();

        $participants = $this->participantMainMatchRepository->getParticipantsByUserIds(
            $userIds, 
            [
                ParticipantsStatus::Awaiting
            ], 
            [
                ParticipantMainMatchProperty::User,
                ParticipantMainMatchProperty::UserInfoUpdatedTime
            ]
        );
        $oldestParticipants = $this->participantMainMatchService->getListForOldestDatingDayPerUserId($participants)->values();
        
        // To send only final reminder to user who is less than one day between approvedAt and deadline
        $participantsBeforeLastDayOfDeadline = $oldestParticipants->filter(function ($participant) {
            /** @var ParticipantMainMatch $participant */
            return $participant->getUser()->getUserInfoUpdatedTime()->getApprovedAt()
                ->lt($participant->getParticipateDeadline()->copy()->subDay());
        });
        
        $usersBeforeLastDayOfDeadline = $participantsBeforeLastDayOfDeadline->map(function ($participant) {
            return $participant->getUser();
        });
        
        return $usersBeforeLastDayOfDeadline;
    }
}
