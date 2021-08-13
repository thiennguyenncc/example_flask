<?php

namespace Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers;

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

class ParticipantUsersIncompleteRegisterDeadlineTomorrow extends AbstractEligibleReceiver
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
     * AutoCancelParticipationUsers constructor.
     * @param UserRepositoryInterface $userRepository
     * @param DatingRepositoryInterface $datingRepository
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
        $participantsIncompleteRegister = $this->participantMainMatchRepository->getAllNotCompletedRegistrationByStatus(ParticipantsStatus::Awaiting);
        
        $participantsIncompleteRegisterDeadlineTomorrow = $participantsIncompleteRegister->filter(function ($participant) {
            /** @var ParticipantMainMatch $participant */
            return $participant->getParticipateDeadline()->eq(Carbon::tomorrow()->startOfDay());
        });
        
        $userCollection = $participantsIncompleteRegisterDeadlineTomorrow->map(function ($participant) {
            return $participant->getUser();
        });
        
        return $userCollection;
    }
}
