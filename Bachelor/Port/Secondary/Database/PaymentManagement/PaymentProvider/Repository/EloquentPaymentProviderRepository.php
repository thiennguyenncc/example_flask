<?php

namespace Bachelor\Port\Secondary\Database\PaymentManagement\PaymentProvider\Repository;

use Bachelor\Domain\PaymentManagement\PaymentProvider\Interfaces\PaymentProviderRepositoryInterface;
use Bachelor\Domain\PaymentManagement\PaymentProvider\Models\PaymentProvider;
use Bachelor\Port\Secondary\Database\Base\EloquentBaseRepository;
use Bachelor\Port\Secondary\Database\PaymentManagement\PaymentProvider\ModelDao\PaymentProvider as PaymentProviderDao;
use Exception;

class EloquentPaymentProviderRepository extends EloquentBaseRepository implements PaymentProviderRepositoryInterface
{
    /**
     * EloquentPaymentProviderRepository constructor.
     * @param PaymentProviderDao $model
     */
    public function __construct(PaymentProviderDao $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $value
     * @param string $column
     * @return PaymentProvider
     */
    public function getSpecificPaymentProvider($value, string $column = 'stripe_plan_id'): PaymentProvider
    {
        return $this->modelDAO->getSpecificData($value, $column)->first()->toDomainEntity();
    }

    /**
     * @param string $value
     * @return PaymentProvider
     */
    public function getPaymentProviderByName(string $name): PaymentProvider
    {
        $paymentProvider = $this->modelDAO->getSpecificData(lcfirst($name), 'name')->first();

        if ($paymentProvider) {
            return $paymentProvider->toDomainEntity();
        }

        throw new Exception(__("api_messages.payment_provider.payment_provider_not_found"));
    }

    /**
     * Create new payment provider
     *
     * @param PaymentProvider $userPlan
     * @return mixed
     */
    public function save(PaymentProvider $userPlan): PaymentProvider
    {
        return $this->createModelDAO($userPlan->getId())->saveData($userPlan);
    }
}
