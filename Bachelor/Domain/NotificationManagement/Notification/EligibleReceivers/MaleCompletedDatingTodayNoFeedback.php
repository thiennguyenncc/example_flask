<?php

namespace Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers;

use Bachelor\Domain\DatingManagement\Dating\Services\DatingDomainService;
use Bachelor\Domain\PaymentManagement\Subscription\Enum\SubscriptionStatus;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\SubscriptionRepositoryInterface;

class MaleCompletedDatingTodayNoFeedback extends AbstractEligibleReceiver
{
    /**
     * @var DatingRepositoryInterface
     */
    private DatingRepositoryInterface $datingRepository;

    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * @var SubscriptionRepositoryInterface
     */
    private SubscriptionRepositoryInterface $subscriptionRepository;

    /**
     * @var DatingDomainService
     */
    private DatingDomainService $datingDomainService;

    public function __construct(
        DatingRepositoryInterface $datingRepository,
        UserRepositoryInterface $userRepository,
        SubscriptionRepositoryInterface $subscriptionRepository,
        DatingDomainService $datingDomainService
    ) {
        $this->datingRepository = $datingRepository;
        $this->userRepository = $userRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->datingDomainService = $datingDomainService;
    }

    /**
     * @return Collection
     */
    public function retrieve(): Collection
    {
        $datings = $this->datingRepository->getDatingsCompletedToday();

        $userIds = $this->datingDomainService->getUIdsNoFBByPartner($datings);
        $users = $this->userRepository->getByIds($userIds);

        $paidMaleCompletedDatingToday = array();
        foreach ($users as $user) {
            $subscription = $this->subscriptionRepository->getLatestSubscription($user);
            if (!is_null($subscription) && $subscription->getStatus() == SubscriptionStatus::Active) {
                $paidMaleCompletedDatingToday[] = $user;
            }
        }

        return collect($paidMaleCompletedDatingToday);
    }
}
