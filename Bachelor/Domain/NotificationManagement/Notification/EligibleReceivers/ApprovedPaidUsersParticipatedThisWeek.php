<?php

namespace Bachelor\Domain\NotificationManagement\Notification\EligibleReceivers;

use Bachelor\Domain\Base\Condition;
use Bachelor\Domain\Base\Filter;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Model\ParticipantMainMatch;
use Bachelor\Domain\PaymentManagement\Subscription\Enum\SubscriptionStatus;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\SubscriptionRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Enums\UserFilter;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserProperty;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Utility\Helpers\CollectionHelper;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ApprovedPaidUsersParticipatedThisWeek extends AbstractEligibleReceiver
{
    private UserRepositoryInterface $userRepository;

    private ParticipantMainMatchRepositoryInterface $participantMainMatchRepository;

    private SubscriptionRepositoryInterface $subscriptionRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepository,
        SubscriptionRepositoryInterface $subscriptionRepository
    ) {
        $this->userRepository = $userRepository;
        $this->participantMainMatchRepository = $participantMainMatchRepository;
        $this->subscriptionRepository = $subscriptionRepository;
    }

    /**
     * @return Collection|User[]
     */
    public function retrieve(): Collection
    {
        $filter = (new Filter())->addCondition(Condition::make(UserFilter::Status, UserStatus::ApprovedUser))
            ->addCondition(Condition::make(UserFilter::Gender,  UserGender::Male));

        $userList = $this->userRepository->getList($filter);
        $userIds = CollectionHelper::convEntitiesToPropertyArray($userList, UserProperty::Id);
        $participants = $this->participantMainMatchRepository->getParticipatedHistoryForUsersInSameWeek($userIds, Carbon::now());

        return $userList->filter(function ($user) use ($participants) {
            /* @var User $user */
            return is_null($participants->first(function ($participant) use ($user) {
                /* @var ParticipantMainMatch $participant */
                return $participant->getUserId() == $user->getId();
            }));
        })->filter(function ($user) {
            /* @var User $user */
            $subscription = $this->subscriptionRepository->getLatestSubscription($user);

            return !is_null($subscription) && $subscription->getStatus() == SubscriptionStatus::Active;
        });
    }
}
