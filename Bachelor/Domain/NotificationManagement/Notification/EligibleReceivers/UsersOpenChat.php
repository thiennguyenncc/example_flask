<?php

namespace Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers;

use Bachelor\Domain\DatingManagement\Dating\Enums\DatingUserProperty;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantsStatus;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Utility\Helpers\CollectionHelper;
use Illuminate\Support\Collection;

class UsersOpenChat
{
    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    /**
     * @var ParticipantMainMatchRepositoryInterface
     */
    protected ParticipantMainMatchRepositoryInterface $participantMainMatchRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->participantMainMatchRepository =$participantMainMatchRepository;
    }

    /**
     * @return Collection
     */
    public function retrieve(): Collection
    {
        $tomorrow = now()->addDay();
        $participants = $this->participantMainMatchRepository->getParticipantsByStatusAndDate(ParticipantsStatus::Matched, $tomorrow);
        $userIds = CollectionHelper::convEntitiesToPropertyArray($participants, DatingUserProperty::UserId);

        return $this->userRepository->getByIds($userIds);
    }
}
