<?php

namespace Bachelor\Application\User\Providers;

use Bachelor\Application\User\Services\Interfaces\PaymentServiceInterface;
use Bachelor\Application\User\Services\Interfaces\StripeServiceInterface;
use Bachelor\Application\User\Services\Interfaces\TrialPeriodServiceInterface;
use Bachelor\Application\User\Services\PaymentService;
use Bachelor\Application\User\Services\StripeService;
use Bachelor\Application\User\Services\TrialPeriodService;
use Bachelor\Domain\PaymentManagement\Invoice\Interfaces\ExtChargeRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Invoice\Interfaces\ExtInvoiceRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Invoice\Interfaces\InvoiceRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Payment\Interfaces\PaymentRepositoryInterface;
use Bachelor\Domain\PaymentManagement\PaymentCard\Interfaces\PaymentCardInterface;
use Bachelor\Domain\PaymentManagement\PaymentProvider\Interfaces\PaymentProviderRepositoryInterface;
use Bachelor\Domain\PaymentManagement\PaymentProvider\Services\Interfaces\PaymentProviderLogicInterface;
use Bachelor\Domain\PaymentManagement\Plan\Interfaces\PlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Stripe\Model\Stripe;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\ExtSubscriptionRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\SubscriptionRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Interfaces\ExtPaymentCustomerRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Interfaces\UserPaymentCustomerRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\ExtUserPlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\UserPlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Interfaces\UserTrialRepositoryInterface;
use Bachelor\Port\Secondary\Database\PaymentManagement\Invoice\Repository\EloquentInvoiceRepository;
use Bachelor\Port\Secondary\Database\PaymentManagement\Payment\Repository\EloquentPaymentRepository;
use Bachelor\Port\Secondary\Database\PaymentManagement\PaymentCard\Repository\EloquentPaymentCardRepository;
use Bachelor\Port\Secondary\Database\PaymentManagement\PaymentProvider\Repository\EloquentPaymentProviderRepository;
use Bachelor\Port\Secondary\Database\PaymentManagement\Plan\Repository\EloquentPlanRepository;
use Bachelor\Port\Secondary\Database\PaymentManagement\Plan\Repository\EloquentUserPlanRepository;
use Bachelor\Port\Secondary\Database\PaymentManagement\Subscription\Repository\EloquentSubscriptionRepository;
use Bachelor\Port\Secondary\Database\PaymentManagement\UserPaymentCustomer\Repository\EloquentUserPaymentCustomerRepository;
use Bachelor\Port\Secondary\Database\PaymentManagement\UserTrial\Repository\EloquentUserTrialRepository;
use Bachelor\Port\Secondary\PaymentManagement\Stripe\Repository\StripeCharge;
use Bachelor\Port\Secondary\PaymentManagement\Stripe\Repository\StripeCustomer;
use Bachelor\Port\Secondary\PaymentManagement\Stripe\Repository\StripeInvoice;
use Bachelor\Port\Secondary\PaymentManagement\Stripe\Repository\StripeSubscription;
use Bachelor\Port\Secondary\PaymentManagement\Stripe\Repository\StripeSubscriptionSchedule;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Application
        $this->app->bind(PaymentServiceInterface::class, PaymentService::class);
        $this->app->bind(StripeServiceInterface::class, StripeService::class);
        $this->app->bind(TrialPeriodServiceInterface::class, TrialPeriodService::class);

        // @TODO: Domain services need to be removed
        $this->app->bind(PaymentProviderLogicInterface::class, Stripe::class);

        // Repository
        $this->app->bind(PaymentRepositoryInterface::class, EloquentPaymentRepository::class);
        $this->app->bind(PaymentProviderRepositoryInterface::class, EloquentPaymentProviderRepository::class);
        $this->app->bind(PlanRepositoryInterface::class, EloquentPlanRepository::class);
        $this->app->bind(UserPlanRepositoryInterface::class, EloquentUserPlanRepository::class);
        $this->app->bind(InvoiceRepositoryInterface::class, EloquentInvoiceRepository::class);
        $this->app->bind(PaymentCardInterface::class, EloquentPaymentCardRepository::class);
        $this->app->bind(UserPaymentCustomerRepositoryInterface::class, EloquentUserPaymentCustomerRepository::class);
        $this->app->bind(SubscriptionRepositoryInterface::class, EloquentSubscriptionRepository::class);
        $this->app->bind(UserTrialRepositoryInterface::class, EloquentUserTrialRepository::class);
        $this->app->bind(ExtChargeRepositoryInterface::class, StripeCharge::class);
        $this->app->bind(ExtInvoiceRepositoryInterface::class, StripeInvoice::class);
        $this->app->bind(ExtSubscriptionRepositoryInterface::class, StripeSubscription::class);
        $this->app->bind(ExtPaymentCustomerRepositoryInterface::class, StripeCustomer::class);
        $this->app->bind(ExtUserPlanRepositoryInterface::class, StripeSubscriptionSchedule::class);
    }
}
