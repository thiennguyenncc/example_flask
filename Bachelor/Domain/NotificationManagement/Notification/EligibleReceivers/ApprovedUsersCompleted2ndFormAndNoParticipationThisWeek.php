<?php

namespace Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers;

use Bachelor\Domain\Base\Condition;
use Bachelor\Domain\Base\Filter;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Model\ParticipantMainMatch;
use Bachelor\Domain\UserManagement\Registration\Enums\RegistrationSteps;
use Bachelor\Domain\UserManagement\User\Enums\UserFilter;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ApprovedUsersCompleted2ndFormAndNoParticipationThisWeek extends AbstractEligibleReceiver
{
    private UserRepositoryInterface $userRepository;

    private ParticipantMainMatchRepositoryInterface $participantMainMatchRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepository
    ) {
        $this->userRepository = $userRepository;
        $this->participantMainMatchRepository = $participantMainMatchRepository;
    }

    /**
     * @return Collection
     */
    public function retrieve(): Collection
    {
        $filter = new Filter();

        $filter->addCondition(Condition::make(UserFilter::Status, UserStatus::ApprovedUser))
            ->addCondition(Condition::make(UserFilter::RegistrationSteps, RegistrationSteps::StepFinal));

        $userList = $this->userRepository->getList($filter);

        $participants = $this->participantMainMatchRepository->getAwaitingForUsersInSameWeek($userList, Carbon::now());

        return $userList->filter(function ($user) use ($participants) {
            /* @var User $user */
            return is_null($participants->first(function ($participant) use ($user) {
                /* @var ParticipantMainMatch $participant */
                return $participant->getUserId() == $user->getId();
            }));
        });
    }
}
