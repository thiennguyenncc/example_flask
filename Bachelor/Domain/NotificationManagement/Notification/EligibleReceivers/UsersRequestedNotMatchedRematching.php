<?php

namespace Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers;

use Bachelor\Domain\DatingManagement\Dating\Enums\DatingUserProperty;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Enums\ParticipantForRematchStatus;
use Bachelor\Domain\DatingManagement\ParticipantForRematch\Interfaces\ParticipantForRematchRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Utility\Helpers\CollectionHelper;
use Illuminate\Support\Collection;

class UsersRequestedNotMatchedRematching extends AbstractEligibleReceiver
{
    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    /**
     * @var ParticipantForRematchRepositoryInterface
     */
    protected ParticipantForRematchRepositoryInterface $participantForRematchRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ParticipantForRematchRepositoryInterface $participantForRematchRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->participantForRematchRepository = $participantForRematchRepository;
    }

    public function retrieve(): Collection
    {
        $participants = $this->participantForRematchRepository->getParticipantsRematchingByStatusAndDate(ParticipantForRematchStatus::Unmatched, now());
        $userIds = CollectionHelper::convEntitiesToPropertyArray($participants, DatingUserProperty::UserId);

        return $this->userRepository->getByIds($userIds);
    }
}
