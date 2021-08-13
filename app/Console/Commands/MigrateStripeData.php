<?php

namespace App\Console\Commands;

use Bachelor\Domain\PaymentManagement\Invoice\Enum\InvoiceStatus;
use Bachelor\Domain\PaymentManagement\Invoice\Interfaces\InvoiceRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Invoice\Models\Invoice as DomainInvoice;
use Bachelor\Domain\PaymentManagement\Invoice\Models\InvoiceItem;
use Bachelor\Domain\PaymentManagement\PaymentCard\Interfaces\PaymentCardInterface;
use Bachelor\Domain\PaymentManagement\PaymentCard\Models\PaymentCard;
use Bachelor\Domain\PaymentManagement\PaymentProvider\Enum\PaymentGateway;
use Bachelor\Domain\PaymentManagement\PaymentProvider\Interfaces\PaymentProviderRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Plan\Enum\CostPlan;
use Bachelor\Domain\PaymentManagement\Plan\Models\Plan as DomainPlan;
use Bachelor\Domain\PaymentManagement\Plan\Interfaces\PlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\ExtSubscriptionRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\SubscriptionRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Subscription\Models\Subscription as DomainSubscription;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Interfaces\UserPaymentCustomerRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Models\UserPaymentCustomer;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Services\UserPaymentCustomerService;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\UserPlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Enum\TrialStatus;
use Bachelor\Domain\PaymentManagement\UserTrial\Interfaces\UserTrialRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Models\UserTrial;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Stripe\Invoice;
use Stripe\Plan;
use Stripe\Product;
use Stripe\Stripe;
use Stripe\Subscription;

class MigrateStripeData extends Command
{
    /**
     * The name and signature of the console command.
     * limit: limit records for migrate, maximum 100.
     * migrate-all: handle get all records from Stripe.
     *
     * @var string
     */
    protected $signature = 'migrate:stripe {--limit=100} {--migrate-all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data from Stripe';

    private string $paymentGateway;
    private PlanRepositoryInterface $planRepository;
    private PaymentCardInterface $paymentCardRepository;
    private UserPaymentCustomerService $userPaymentCustomerService;
    private PaymentProviderRepositoryInterface $paymentProviderRepository;
    private UserRepositoryInterface $userRepository;
    private InvoiceRepositoryInterface $invoiceRepository;
    private UserPlanRepositoryInterface $userPlanRepository;
    private UserPaymentCustomerRepositoryInterface $userPaymentCustomerRepository;
    private SubscriptionRepositoryInterface $subscriptionRepository;
    private UserTrialRepositoryInterface $userTrialRepository;
    private ExtSubscriptionRepositoryInterface $extSubscriptionRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        PaymentCardInterface $paymentCardRepository,
        PlanRepositoryInterface $planRepository,
        UserPlanRepositoryInterface $userPlanRepository,
        UserPaymentCustomerService $userPaymentCustomerService,
        UserPaymentCustomerRepositoryInterface $userPaymentCustomerRepository,
        UserRepositoryInterface $userRepository,
        InvoiceRepositoryInterface $invoiceRepository,
        PaymentProviderRepositoryInterface $paymentProviderRepository,
        SubscriptionRepositoryInterface $subscriptionRepository,
        UserTrialRepositoryInterface $userTrialRepository,
        ExtSubscriptionRepositoryInterface $extSubscriptionRepository
    )
    {
        parent::__construct();
        $this->paymentGateway = PaymentGateway::Stripe;
        Stripe::setApiKey(config('services.stripe.' . env('STRIPE_MODE', 'test') . '.secret'));
        $this->paymentCardRepository = $paymentCardRepository;
        $this->planRepository = $planRepository;
        $this->userPaymentCustomerService = $userPaymentCustomerService;
        $this->userPaymentCustomerRepository = $userPaymentCustomerRepository;
        $this->userRepository = $userRepository;
        $this->userPlanRepository = $userPlanRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->paymentProviderRepository = $paymentProviderRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->userTrialRepository = $userTrialRepository;
        $this->extSubscriptionRepository = $extSubscriptionRepository;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->info('Start migrating...');
            $limit = $this->option('limit');
            $isMigrateAllRecord = !!$this->option('migrate-all');

            $this->migrateStripePlans($limit, $isMigrateAllRecord);
            $this->info('');
            $this->info('Finish migrating Stripe Plans!');
            $this->migrateStripeCustomers($limit, $isMigrateAllRecord);
            $this->info('');
            $this->info('Finish migrating Stripe Customers!');
            $this->migrateStripeSubscriptions($limit, $isMigrateAllRecord);
            $this->info('');
            $this->info('Finish migrating Stripe Subscriptions!');
            $this->migrateStripeInvoices($limit, $isMigrateAllRecord);
            $this->info('');
            $this->info('Finish migrating Stripe Invoices!');
            $this->info('');
            $this->info('Finish migrating!');
        } catch (Exception $exception) {
            $this->info($exception->getMessage());
        }
    }

    /**
     * Get Plans from Stripe and store to database.
     *
     * @param int $limit
     * @param bool $isMigrateAllRecord
     * @return void
     * @throws ApiErrorException
     * @throws Exception
     */
    private function migrateStripeCustomers(int $limit, bool $isMigrateAllRecord): void
    {
        $customers = Customer::all(["limit" => $limit, "expand" => ['data.sources']]);
        $this->handleCustomersMigrated($customers->data);

        if (!$isMigrateAllRecord) {
            return;
        }

        while ($customers->has_more) {
            $customers = $customers->nextPage();
            $this->handleCustomersMigrated($customers->data);
        }
    }

    /**
     * Get Plans from Stripe
     *
     * @param int $limit
     * @param bool $isMigrateAllRecord
     * @return void
     * @throws ApiErrorException
     */
    private function migrateStripePlans(int $limit, bool $isMigrateAllRecord): void
    {
        $plans = Plan::all(["limit" => $limit]);
        $this->handlePlansMigrated($plans->data);

        if (!$isMigrateAllRecord) {
            return;
        }

        while ($plans->has_more) {
            $plans = $plans->nextPage();
            $this->handlePlansMigrated($plans->data);
        }
    }

    /**
     * Get Subscriptions from Stripe
     *
     * @param int $limit
     * @param bool $isMigrateAllRecord
     * @return void
     * @throws ApiErrorException
     */
    private function migrateStripeSubscriptions(int $limit, bool $isMigrateAllRecord): void
    {
        $subscriptions = Subscription::all(["limit" => $limit]);
        $this->handleSubscriptionsMigrated($subscriptions->data);

        if (!$isMigrateAllRecord) {
            return;
        }

        while ($subscriptions->has_more) {
            $subscriptions = $subscriptions->nextPage();
            $this->handleSubscriptionsMigrated($subscriptions->data);
        }
    }

    /**
     * Get Invoices from Stripe
     *
     * @param int $limit
     * @param bool $isMigrateAllRecord
     * @return void
     * @throws ApiErrorException
     */
    private function migrateStripeInvoices(int $limit, bool $isMigrateAllRecord): void
    {
        $invoices = Invoice::all(["limit" => $limit]);
        $this->handleInvoicesMigrated($invoices->data);
        if (!$isMigrateAllRecord) {
            return;
        }

        while ($invoices->has_more) {
            $invoices = $invoices->nextPage();
            $this->handleInvoicesMigrated($invoices->data);
        }
    }

    /**
     * Handle migrate Plans from Stripe
     *
     * @param array $stripePlansObject
     * @return void
     * @throws ApiErrorException
     */
    private function handlePlansMigrated(array $stripePlansObject): void
    {
        $plans = [];
        foreach ($stripePlansObject as $stripePlan) {
            $product = Product::retrieve($stripePlan['product']);
            $costPlan = $this->getCostPlanKeyByStripePlanName(strtolower($product->name));
            if (!$costPlan) {
                Log::error(__('api_messages.stripe.cost_plan_key_incorrect') . $product->name);
                continue;
            }

            $plan = $this->planRepository->getPlanByThirdPartyPlanId($stripePlan['id']);
            if (!$plan) {
                array_push($plans, new DomainPlan(
                    $stripePlan['id'],
                    $product ? $product->name : "",
                    $stripePlan['nickname'] ?? "",
                    "",
                    $stripePlan['metadata']['cost_plan'] ?? $costPlan,
                    1,
                    $stripePlan['amount']
                ));
            }
        }

        $this->planRepository->saveAll(collect($plans));
    }

    /**
     * @param string $name
     * @return string|null
     */
    private function getCostPlanKeyByStripePlanName(string $name): string|null
    {
        return match (true) {
            Str::contains($name, ['プレミアム', 'premium']) => CostPlan::Premium,
            Str::contains($name, ['ベーシック', 'normal']) => CostPlan::Normal,
            Str::contains($name, ['お手軽', 'light']) => CostPlan::Light,
            default => null,
        };
    }

    /**
     * Handle migrate Customers from Stripe
     *
     * @param array $stripeCustomerObjects
     * @return void
     * @throws Exception
     */
    private function handleCustomersMigrated(array $stripeCustomerObjects): void
    {
        $userPaymentCustomers = [];
        foreach ($stripeCustomerObjects as $stripeCustomerObject) {
            if (isset($stripeCustomerObject['metadata']['user_id'])) {
                $user = $this->userRepository->getById((int)$stripeCustomerObject['metadata']['user_id']);
            } else {
                $user = $stripeCustomerObject['email'] ? $this->userRepository->getUserByEmail($stripeCustomerObject['email']) : null;
            }

            if (!$user) {
                Log::error(__('api_messages.stripe.user_does_not_exist') . $stripeCustomerObject['id']);
                continue;
            }

            if ($user->getUserPaymentCustomer()) {
                Log::error(__('api_messages.stripe.user_has_payment_customer_already') . $user->getId());
                continue;
            }

            $userPaymentCustomer = $this->userPaymentCustomerRepository->getUserPaymentCustomerByThirdPartyId($stripeCustomerObject['id']);
            if(!$userPaymentCustomer) {
                $paymentProvider = $this->paymentProviderRepository->getPaymentProviderByName($this->paymentGateway);
                array_push($userPaymentCustomers, new UserPaymentCustomer(
                    $user->getId(),
                    $stripeCustomerObject['id'],
                    $paymentProvider
                ));
            } else {
                $defaultPaymentCard = $stripeCustomerObject['default_source'] ? $this->paymentCardRepository->getPaymentCardByThirdPartyCardId($stripeCustomerObject['default_source']) : null;
                $userPaymentCustomer->setDefaultPaymentCard($defaultPaymentCard);
                array_push($userPaymentCustomers, $userPaymentCustomer);
            }

            $sources = $stripeCustomerObject['sources']['data'];
            $this->handleCustomerSourcesMigrated($sources);
        }

        $this->userPaymentCustomerRepository->saveAll(collect($userPaymentCustomers));
    }

    /**
     * Handle migrate Customers from Stripe
     *
     * @param array $stripeSourcesObject
     * @return void
     * @throws Exception
     */
    private function handleCustomerSourcesMigrated(array $stripeSourcesObject): void
    {
        $paymentCards = [];
        foreach ($stripeSourcesObject as $source) {
            try {
                $user = $this->userPaymentCustomerService->getUserByThirdPartyCustomerId($source['customer']);
            } catch (Exception $e) {
                Log::error($e->getMessage());
                continue;
            }

            $paymentCard = $this->paymentCardRepository->getPaymentCardByThirdPartyCardId($source['id']);
            if (!$paymentCard) {
                array_push($paymentCards, new PaymentCard(
                    $user->getUserPaymentCustomer()->getId(),
                    $source['id'],
                    $source['last4']
                ));
            }
        }
        $this->paymentCardRepository->saveAll(collect($paymentCards));
    }

    /**
     * Handle migrate Subscription from Stripe
     *
     * @param array $stripeSubscriptionsObject
     * @return void
     * @throws ApiErrorException
     */
    private function handleSubscriptionsMigrated(array $stripeSubscriptionsObject): void
    {
        $subscriptions = [];
        foreach ($stripeSubscriptionsObject as $stripeSubscription) {
            try {
                $user = $this->userPaymentCustomerService->getUserByThirdPartyCustomerId($stripeSubscription['customer']);
            } catch (Exception $e) {
                Log::error($e->getMessage() . $stripeSubscription['customer']);
                continue;
            }

            $subscription = $this->subscriptionRepository->getSubscriptionByThirdPartyId($stripeSubscription['id']);
            if (!$subscription) {
                array_push($subscriptions, new DomainSubscription(
                    $user->getUserPaymentCustomer(),
                    $stripeSubscription['id'],
                    Carbon::parse($stripeSubscription['current_period_start']),
                    Carbon::parse($stripeSubscription['current_period_end'])
                ));
            }

            $this->handleUserPlanMigrated($user, $stripeSubscription->toArray());
            $this->handleUserTrialMigrated($user, $stripeSubscription->toArray());
        }

        $this->subscriptionRepository->saveAll(collect($subscriptions));
    }

    /**
     * Handle migrate UserPlan from Stripe
     *
     * @param User $user
     * @param array $stripeSubscription
     * @return void
     * @throws ApiErrorException
     */
    private function handleUserPlanMigrated(User $user, array $stripeSubscription): void
    {
        $currentUserPlan = $this->userPlanRepository->getActiveUserPlanByUserId($user->getId());
        $stripePlanObject = $stripeSubscription['items']['data'][0]['plan'];
        if (!$currentUserPlan || $currentUserPlan->getPlan()->getThirdPartyPlanId() !== $stripePlanObject['id']) {
            Log::error(__('api_messages.stripe.user_does_not_has_plan' . $stripePlanObject['id']));
            return;
        }

        $currentUserPlan->setActivateAt(Carbon::parse($stripeSubscription['created']));
        $this->userPlanRepository->save($currentUserPlan);

        if ($stripePlanObject['trial_period_days'] > 0) {
            $this->cancelTrialSubscription($stripeSubscription);
        }
    }

    /**
     * Handle migrate UserTrial from Stripe
     *
     * @param User $user
     * @param array $stripeSubscription
     * @return void
     */
    private function handleUserTrialMigrated(User $user, array $stripeSubscription): void
    {
        if (!$stripeSubscription['trial_start'] || !$stripeSubscription['trial_end']) {
            return;
        }

        $trialStatus = $stripeSubscription['trial_end'] < Carbon::now()->timestamp ? TrialStatus::Completed : TrialStatus::Active;
        $userTrial = new UserTrial(
            $user->getId(),
            Carbon::createFromTimestamp((int)$stripeSubscription['trial_start']),
            Carbon::createFromTimestamp((int)$stripeSubscription['trial_end']),
            $trialStatus
        );

        $this->userTrialRepository->save($userTrial);
    }

    /**
     * Cancel Trial Subscription
     *
     * @param array $stripeSubscription
     * @return void
     * @throws ApiErrorException
     */
    private function cancelTrialSubscription(array $stripeSubscription): void
    {
        $subscription = $this->subscriptionRepository->getSubscriptionByThirdPartyId($stripeSubscription['id']);
        $this->extSubscriptionRepository->cancelSubscription($subscription);
    }

    /**
     * Handle migrate Invoices from Stripe
     *
     * @param array $stripeInvoicesObject
     * @return void
     */
    private function handleInvoicesMigrated(array $stripeInvoicesObject): void
    {
        foreach ($stripeInvoicesObject as $stripeInvoiceObject) {
            try {
                $user = $this->userPaymentCustomerService->getUserByThirdPartyCustomerId($stripeInvoiceObject['customer']);
            } catch (Exception $e) {
                Log::error($e->getMessage() . $stripeInvoiceObject['id']);
                continue;
            }

            $invoiceItems = [];
            foreach ($stripeInvoiceObject['lines']['data'] as $invoiceItem) {
                $invoiceItems[] = new InvoiceItem($invoiceItem['amount'], $invoiceItem['description']);
            }

            $invoice = $this->invoiceRepository->getInvoiceByThirdPartyInvoiceId($stripeInvoiceObject['id']);
            if (!$invoice) {
                $subscription = $stripeInvoiceObject['subscription']
                    ? $this->subscriptionRepository->getSubscriptionByThirdPartyId($stripeInvoiceObject['subscription'])
                    : null;

                $newInvoice = new DomainInvoice(
                    $user->getUserPaymentCustomer(),
                    $stripeInvoiceObject['id'],
                    collect($invoiceItems),
                    $stripeInvoiceObject['description'] ?? '',
                    $subscription?->getId() ?? null,
                    InvoiceStatus::translateFromStripe($stripeInvoiceObject['status']),
                    $stripeInvoiceObject['auto_advance'],
                    $stripeInvoiceObject['hosted_invoice_url']
                );

                $this->invoiceRepository->save($newInvoice);
            }
        }
    }
}
