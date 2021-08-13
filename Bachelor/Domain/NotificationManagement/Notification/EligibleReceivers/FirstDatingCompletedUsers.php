<?php

namespace Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers;

use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Domain\DatingManagement\Dating\Enums\DatingUserProperty;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;

class FirstDatingCompletedUsers extends AbstractEligibleReceiver
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var DatingRepositoryInterface
     */
    protected $datingRepository;
    
    /**
     * AutoCancelParticipationUsers constructor.
     * @param UserRepositoryInterface $userRepository
     * @param DatingRepositoryInterface $datingRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        DatingRepositoryInterface $datingRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->datingRepository = $datingRepository;
    }

    public function retrieve(): Collection
    {
        $completedDatingsLastWeek = $this->datingRepository->getDatingsFromTo(
            now()->subWeek()->startOfWeek(),
            now()->subWeek()->endOfWeek(),
            DatingStatus::Completed
        );

        $userIdArray = [];
        foreach ($completedDatingsLastWeek as $dating) {
            foreach ($dating->getDatingUsers() as $datingUser) {
                $userIdArray[] = $datingUser->getUserId();
            }
        }

        $latestDatingUsers = $this->datingRepository->getLatestDatingUsersByUserIds(
            $userIdArray, [DatingUserProperty::User]
        );

        $users = $latestDatingUsers->map(function ($datingUser) {
            return $datingUser->getUser();
        });
        
        return $users;
    }
}
