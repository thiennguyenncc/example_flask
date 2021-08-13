<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\UserPaymentCustomer\Repository;

use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Interfaces\UserPaymentCustomerRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Models\UserPaymentCustomer;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\PaymentManagement\UserPaymentCustomer\ModelDao\UserPaymentCustomer as UserPaymentCustomerDao;

class EloquentUserPaymentCustomerRepository extends EloquentBaseRepository implements UserPaymentCustomerRepositoryInterface
{
    /**
     * EloquentUserPaymentCustomerRepository constructor.
     * @param UserPaymentCustomerDao $subscription
     */
    public function __construct(UserPaymentCustomerDao $modelDao)
    {
        parent::__construct($modelDao);
    }

    /**
     *
     * @param string $customerId
     * @return UserPaymentCustomer|null
     */
    public function getUserPaymentCustomerByThirdPartyId(string $customerId): ?UserPaymentCustomer
    {
        return optional($this->createModelDAO()->where('third_party_customer_id', $customerId)->first())->toDomainEntity();
    }

    /**
     *
     * @param int $user_id
     * @return UserPaymentCustomer|null
     */
    public function getUserPaymentCustomerByUserId(int $user_id): ?UserPaymentCustomer
    {
        return optional($this->createModelDAO()->where('user_id', $user_id)->first())->toDomainEntity();
    }

    /**
     * Create new user payment customer
     *
     * @param UserPaymentCustomer $userPaymentCustomer
     * @return UserPaymentCustomer
     */
    public function save(UserPaymentCustomer $userPaymentCustomer): UserPaymentCustomer
    {
        return $this->createModelDAO($userPaymentCustomer->getId())->saveData($userPaymentCustomer);
    }
}
