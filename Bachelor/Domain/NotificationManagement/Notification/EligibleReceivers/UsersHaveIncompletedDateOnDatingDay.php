<?php

namespace Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers;

use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\DatingManagement\DatingDay\Interfaces\DatingDayRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class UsersHaveIncompletedDateOnDatingDay
{
    protected DatingRepositoryInterface $datingRepository;
    protected DatingDayRepositoryInterface $datingDayRepository;
    protected UserRepositoryInterface $userRepository;


    public function __construct(
        UserRepositoryInterface $userRepository,
        DatingRepositoryInterface $datingRepository,
        DatingDayRepositoryInterface $datingDayRepository
    ) {
        $this->userRepository = $userRepository;
        $this->datingRepository = $datingRepository;
        $this->datingDayRepository = $datingDayRepository;
    }

    /**
     * @return Collection
     */
    public function retrieve(): Collection
    {
        $datingDay = $this->datingDayRepository->getByDate(Carbon::today()->toDateString());
        $datingCollection = $this->datingRepository->getIncompletedDatingsByDatingDay($datingDay->getId());
        $userIds = [];
        foreach ($datingCollection as $dating) {
            foreach ($dating->getDatingUsers() as $datingUser) {
                $userIds[] = $datingUser->getUserId();
            }
        }
        return $this->userRepository->getByIds($userIds);
    }
}
