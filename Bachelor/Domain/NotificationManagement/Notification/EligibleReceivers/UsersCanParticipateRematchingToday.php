<?php


namespace Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers;


use Bachelor\Domain\DatingManagement\Dating\Enums\DatingUserProperty;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantsStatus;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Utility\Helpers\CollectionHelper;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class UsersCanParticipateRematchingToday
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
        $this->participantMainMatchRepository = $participantMainMatchRepository;
    }

    /**
     * @return Collection
     */
    public function retrieve(): Collection
    {
        $today = Carbon::now();
        $participants = $this->participantMainMatchRepository->getParticipantsByStatusAndDate(ParticipantsStatus::Unmatched, $today);
        $userIds = CollectionHelper::convEntitiesToPropertyArray($participants, DatingUserProperty::UserId);

        return $this->userRepository->getByIds($userIds);
    }
}
