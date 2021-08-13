<?php

namespace Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers;

use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantsStatus;
use Bachelor\Domain\PaymentManagement\UserTrial\Interfaces\UserTrialRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Enum\TrialStatus;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;

class TempCancelTrialNoParticipantUsers extends AbstractEligibleReceiver
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var UserTrialRepositoryInterface
     */
    protected $userTrialRepository;    
    
    /**
     * @var ParticipantMainMatchRepositoryInterface
     */
    protected $participantMainMatchRepository;    
    
    /**
     * AutoCancelParticipationUsers constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UserTrialRepositoryInterface $userTrialRepository
     * @param ParticipantMainMatchRepositoryInterface $participantMainMatchRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        UserTrialRepositoryInterface $userTrialRepository,
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->userTrialRepository = $userTrialRepository;
        $this->participantMainMatchRepository = $participantMainMatchRepository;
    }

    public function retrieve(): Collection
    {
        $tempCancelTrials = $this->userTrialRepository->getAllLatestUserTrialByStatus(TrialStatus::TempCancelled);

        $userIdArray = $tempCancelTrials->map(function ($trial) {
            return $trial->getUserId();
        })->toArray();

        $participantMainMatches = $this->participantMainMatchRepository->getParticipantsByUserIds(
            $userIdArray, [ParticipantsStatus::Awaiting]
        );

        $userIdsTempCancelTrialNoParticipant = $tempCancelTrials->reject( function ($user) use ($participantMainMatches) {
            foreach ($participantMainMatches as $participation) {
                if ($participation->getUserId() == $user->getId()) {
                    return true;
                }
            }
        })->map(function ($trial) {
            return $trial->getUserId();
        })->toArray();

        $eligibleUsers = $this->userRepository->getByIds($userIdsTempCancelTrialNoParticipant);
                
        return $eligibleUsers;
    }
}
