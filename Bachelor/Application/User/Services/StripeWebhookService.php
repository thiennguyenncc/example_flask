<?php

namespace Bachelor\Application\User\Services;

use Exception;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Bachelor\Domain\PaymentManagement\Plan\Models\Plan;
use Bachelor\Domain\PaymentManagement\Invoice\Models\Invoice;
use Bachelor\Domain\PaymentManagement\Invoice\Enum\InvoiceStatus;
use Bachelor\Domain\PaymentManagement\Invoice\Models\InvoiceItem;
use Bachelor\Domain\PaymentManagement\PaymentCard\Models\PaymentCard;
use Bachelor\Domain\PaymentManagement\Subscription\Models\Subscription;
use Bachelor\Domain\PaymentManagement\UserPlan\Services\UserPlanService;
use Bachelor\Domain\PaymentManagement\PaymentProvider\Enum\PaymentGateway;
use Bachelor\Domain\PaymentManagement\Subscription\Enum\SubscriptionStatus;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Plan\Interfaces\PlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\PaymentCard\Interfaces\PaymentCardInterface;
use Bachelor\Domain\PaymentManagement\Invoice\Interfaces\InvoiceRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Models\UserPaymentCustomer;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\UserPlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Subscription\Interfaces\SubscriptionRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Services\UserPaymentCustomerService;
use Bachelor\Domain\PaymentManagement\PaymentProvider\Interfaces\PaymentProviderRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Interfaces\UserPaymentCustomerRepositoryInterface;
use Bachelor\Utility\Helpers\Utility;
use Stripe\Product;
use Stripe\Stripe;

class StripeWebhookService
{
    /**
     * Response Status
     */
    protected int $status;

    /**
     * Response Message
     */
    protected string $message;

    /**
     * Response data
     *
     * @var array
     */
    protected array $data = [];

    private PlanRepositoryInterface $planRepository;
    private PaymentCardInterface $paymentCardRepository;
    private UserPlanService $userPlanService;
    private UserPaymentCustomerService $userPaymentCustomerService;
    private PaymentProviderRepositoryInterface $paymentProviderRepository;
    private UserRepositoryInterface $userRepository;
    private InvoiceRepositoryInterface $invoiceRepository;
    private UserPlanRepositoryInterface $userPlanRepository;
    private UserPaymentCustomerRepositoryInterface $userPaymentCustomerRepository;
    private SubscriptionRepositoryInterface $subscriptionRepository;

    public function __construct(
        PaymentCardInterface $paymentCardRepository,
        PlanRepositoryInterface $planRepository,
        UserPlanService $userPlanService,
        UserPlanRepositoryInterface $userPlanRepository,
        UserPaymentCustomerService $userPaymentCustomerService,
        UserPaymentCustomerRepositoryInterface $userPaymentCustomerRepository,
        UserRepositoryInterface $userRepository,
        InvoiceRepositoryInterface $invoiceRepository,
        PaymentProviderRepositoryInterface $paymentProviderRepository,
        SubscriptionRepositoryInterface $subscriptionRepository
    ) {
        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
        $this->paymentGateway = PaymentGateway::Stripe;
        Stripe::setApiKey(config('services.stripe.' . env('STRIPE_MODE', 'test') . '.secret'));

        $this->paymentCardRepository = $paymentCardRepository;
        $this->planRepository = $planRepository;
        $this->userPlanService = $userPlanService;
        $this->userPaymentCustomerService = $userPaymentCustomerService;
        $this->userPaymentCustomerRepository = $userPaymentCustomerRepository;
        $this->userRepository = $userRepository;
        $this->userPlanRepository = $userPlanRepository;
        $this->invoiceRepository = $invoiceRepository;
        $this->paymentProviderRepository = $paymentProviderRepository;
        $this->subscriptionRepository = $subscriptionRepository;
    }

    /**
     * Handle new plan created
     *
     * @param array $stripePlan
     * @return array
     * @throws Exception
     */
    public function handlePlanCreated(array $stripePlan): array
    {
        $product = Product::retrieve($stripePlan['product']);
        $plan = new Plan(
            $stripePlan['id'],
            $product->name,
            $stripePlan['nickname'] ?? "",
            $stripePlan['metadata']['discount_type'] ?? "",
            $stripePlan['metadata']['cost_plan'] ?? "",
            $stripePlan['metadata']['contract_term'] ?? $stripePlan['interval_count'],
            $stripePlan['amount']
        );
        $this->planRepository->save($plan);

        return $this->handleApiResponse();
    }

    /**
     * Handle plan updated
     *
     * @param array $stripePlan
     * @return array
     * @throws Exception
     */
    public function handlePlanUpdated(array $stripePlan): array
    {
        $product = Product::retrieve($stripePlan['product']);
        $plan = $this->planRepository->getPlanByThirdPartyPlanId($stripePlan['id']);
        if (!$plan) {
            throw new Exception(__('api_messages.plan_does_not_exist'));
        }
        $plan->setName($product->name);
        if (isset($stripePlan['nickname'])) $plan->setNickname($stripePlan['nickname']);
        $plan->setFinalAmount($stripePlan['amount']);
        if (isset($stripePlan['metadata']['discount_type'])) $plan->setDiscountType($stripePlan['metadata']['discount_type']);
        if (isset($stripePlan['metadata']['cost_plan'])) $plan->setCostPlanKey($stripePlan['metadata']['cost_plan']);
        $plan->setContractTerm($stripePlan['metadata']['contract_term'] ?? $stripePlan['interval_count']);
        $this->planRepository->save($plan);

        return $this->handleApiResponse();
    }

    /**
     * Handle new customer created
     *
     * @param array $customer
     * @return array
     * @throws Exception
     */
    public function handleCustomerCreated(array $stripeCustomerObject): array
    {
        $alreadyExists = ($this->userPaymentCustomerRepository->getUserPaymentCustomerByThirdPartyId($stripeCustomerObject['id']));
        if ($alreadyExists) {
            $this->message = "the user payment customer already exists";
            return $this->handleApiResponse();
        }
        if (isset($stripeCustomerObject['metadata']['user_id'])) {
            $userId = $stripeCustomerObject['metadata']['user_id'];
        } else {
            $userId = $this->userRepository->getUserByEmail($stripeCustomerObject['email'])->getId();
        }
        $paymentProvider = $this->paymentProviderRepository->getPaymentProviderByName($this->paymentGateway);

        $userPaymentCustomer = new UserPaymentCustomer($userId, $stripeCustomerObject['id'], $paymentProvider);
        $this->userPaymentCustomerRepository->save($userPaymentCustomer);

        return $this->handleApiResponse();
    }

    /**
     * Handle updating stripe customer data
     *
     * @param array $stripeCustomer
     * @return array
     * @throws Exception
     */
    public function handleCustomerUpdated(array $stripeCustomerObject): array
    {
        $userPaymentCustomer = $this->userPaymentCustomerRepository->getUserPaymentCustomerByThirdPartyId($stripeCustomerObject['id']);
        if (!$userPaymentCustomer) {
            throw new Exception(__('api_messages.user_payment_customer_does_not_exist'));
        }
        $defaultPaymentCard = $this->paymentCardRepository->getPaymentCardByThirdPartyCardId($stripeCustomerObject['default_source']);
        if (!$defaultPaymentCard) {
            throw new Exception(__('api_messages.default_payment_card_does_not_exist'));
        }

        $userPaymentCustomer->setDefaultPaymentCard($defaultPaymentCard);
        if (isset($stripeCustomerObject['metadata']['user_id'])) {
            $userPaymentCustomer->setUserId($stripeCustomerObject['metadata']['user_id']);
        }
        $this->userPaymentCustomerRepository->save($userPaymentCustomer);

        return $this->handleApiResponse();
    }

    /**
     * Handle updating stripe subscription
     *
     * @param array $stripeSubscription
     * @return array
     */
    public function handleCustomerSubscriptionCreated(array $stripeSubscriptionObject): array
    {
        $user = $this->userPaymentCustomerService->getUserByThirdPartyCustomerId($stripeSubscriptionObject['customer']);
        if (!$user) {
            throw new Exception(__('api_messages.user_does_not_exist'));
        }

        $subscription = new Subscription(
            $user->getUserPaymentCustomer(),
            $stripeSubscriptionObject['id'],
            Carbon::parse($stripeSubscriptionObject['current_period_start']),
            Carbon::parse($stripeSubscriptionObject['current_period_end'])
        );
        $this->subscriptionRepository->save($subscription);

        $currentUserPlan = $this->userPlanRepository->getActiveUserPlanByUserId($user->getId());
        $stripePlanObject = $stripeSubscriptionObject['items']['data'][0]['plan'];
        if (!$currentUserPlan || $currentUserPlan->getPlan()->getThirdPartyPlanId() !== $stripePlanObject['id']) {
            throw new Exception(__('api_messages.user_does_not_have_plan'));
        }
        $currentUserPlan->setActivateAt(Carbon::parse($stripeSubscriptionObject['created']));
        $this->userPlanRepository->save($currentUserPlan);

        return $this->handleApiResponse();
    }

    /**
     * Handle updating stripe subscription
     *
     * @param array $stripeSubscription
     * @return array
     */
    public function handleCustomerSubscriptionUpdated(array $stripeSubscriptionObject, array $previous_attributes): array
    {
        $user = $this->userPaymentCustomerService->getUserByThirdPartyCustomerId($stripeSubscriptionObject['customer']);
        if (!$user) {
            throw new Exception(__('api_messages.user_does_not_exist'));
        }

        //update Subscription
        $subscription = $this->subscriptionRepository->getSubscriptionByThirdPartyId($stripeSubscriptionObject['id']);
        if (!$subscription) {
            throw new Exception(__('api_messages.subscription_does_not_exist'));
        }
        $subscription->setStartsAt(Carbon::parse($stripeSubscriptionObject['current_period_start']));
        $subscription->setNextStartsAt(Carbon::parse($stripeSubscriptionObject['current_period_end']));
        $subscription->setCancelledAt(Carbon::make($stripeSubscriptionObject['canceled_at']));
        if (in_array($stripeSubscriptionObject['status'], SubscriptionStatus::getValues())) $subscription->setStatus($stripeSubscriptionObject['status']);
        $this->subscriptionRepository->save($subscription);


        if (is_null($stripeSubscriptionObject['schedule']) && isset($previous_attributes['schedule'])) {
            $this->userPlanService->cancelScheduledUserPlan($user);
        }
        if (isset($previous_attributes['items']['data'][0]['plan'])) {
            $currentStripePlanObject = $stripeSubscriptionObject['items']['data'][0]['plan'];
            //if plan changed,
            $scheduledUserPlan = $this->userPlanRepository->getScheduledUserPlanByUserId($user->getId());
            if ($scheduledUserPlan->getPlan()->getThirdPartyPlanId() === $currentStripePlanObject['id']) {
                // activate scheduled plan
                $this->userPlanService->activateScheduledPlan(
                    $user,
                    $scheduledUserPlan,
                    Carbon::parse($stripeSubscriptionObject['items']['data'][0]['created'])
                );
            } else {
                // or start new plan
                $newPlan = $this->planRepository->getPlanByThirdPartyPlanId($currentStripePlanObject['id']);
                $this->userPlanService->startNewActivePlan($user, $newPlan);
            }
        }

        return $this->handleApiResponse();
    }


    public function handleCustomerSubscriptionDeleted(array $stripeSubscriptionObject, array $previous_attributes)
    {
        return $this->handleCustomerSubscriptionUpdated($stripeSubscriptionObject, $previous_attributes);
    }

    /**
     * Handle customer source created
     *
     * @param array $stripeSource
     * @return array
     * @throws Exception
     */
    public function handleCustomerSourceCreated(array $stripeSourceObject): array
    {
        if ($stripeSourceObject['object'] == "card") {
            $paymentCard = Utility::wait(function () use ($stripeSourceObject) {
                return $this->paymentCardRepository->getPaymentCardByThirdPartyCardId($stripeSourceObject['id']);
            });
            $userPaymentCustomer = Utility::wait(function () use ($stripeSourceObject) {
                return $this->userPaymentCustomerService->getUserByThirdPartyCustomerId($stripeSourceObject['customer'])->getUserPaymentCustomer();
            });
            if (!$paymentCard) {
                $paymentCard = new PaymentCard($userPaymentCustomer->getId(), $stripeSourceObject['id'], $stripeSourceObject['last4']);
                $paymentCard = $this->paymentCardRepository->save($paymentCard);
            }

            if (!$userPaymentCustomer?->getDefaultPaymentCard()) {
                $userPaymentCustomer->setDefaultPaymentCard($paymentCard);
                $this->userPaymentCustomerRepository->save($userPaymentCustomer);
            }
        } else {
            throw new Exception(__('api_message.only_card_object_allowed'));
        }

        return $this->handleApiResponse();
    }

    /**
     * Handle customer source updated
     *
     * @param array $stripeSource
     * @return array
     * @throws Exception
     */
    public function handleCustomerSourceUpdated(array $stripeSourceObject): array
    {
        if ($stripeSourceObject['object'] == "card") {
            $paymentCard = $this->paymentCardRepository->getPaymentCardByThirdPartyCardId($stripeSourceObject['id']);
            $paymentCard->setLastFourDigits($stripeSourceObject['last4']);
            $this->paymentCardRepository->save($paymentCard);
        } else {
            throw new Exception(__('api_message.only_card_object_allowed'));
        }

        return $this->handleApiResponse();
    }

    /**
     * Handle customer payment source deleted
     *
     * @param array $stripeSource
     * @return array
     * @throws Exception
     */
    public function handleCustomerSourceDeleted(array $stripeSource): array
    {
        if ($this->paymentCardRepository->deletePaymentCardByThirdPartyCardId($stripeSource['id']))
            return $this->handleApiResponse();

        throw new Exception(__('api_message.failed_to_delete_payment_card'));
    }

    /**
     * Handle scheduled subscription created
     *
     * @param array $stripeSubscriptionSchedule
     * @return array
     */
    public function handleSubscriptionScheduleCreated(array $stripeSubscriptionSchedule): array
    {
        $stripeSubscriptionSchedule = $stripeSubscriptionSchedule;
        $user = $this->userPaymentCustomerService->getUserByThirdPartyCustomerId($stripeSubscriptionSchedule['customer']);

        foreach ($stripeSubscriptionSchedule['phases'] as $phase) {
            if ($stripeSubscriptionSchedule['current_phase']['end_date'] === $phase['start_date']) {
                //next phase
                $nextPlan = $this->planRepository->getPlanByThirdPartyPlanId($phase['items'][0]['plan']);
                $this->userPlanService->scheduleNewUserPlan($user, $nextPlan);
            }
        }

        return $this->handleApiResponse();
    }

    /**
     * Handle scheduled subscription update
     *
     * @param array $stripeSubscriptionSchedule
     * @return array
     */
    public function handleSubscriptionScheduleUpdated(array $stripeSubscriptionSchedule, array $previous_attributes): array
    {
        $user = $this->userPaymentCustomerService->getUserByThirdPartyCustomerId($stripeSubscriptionSchedule['customer']);

        if (isset($previous_attributes['phases'])) {
            foreach ($stripeSubscriptionSchedule['phases'] as $phase) {
                if ($stripeSubscriptionSchedule['current_phase']['end_date'] === $phase['start_date']) {
                    $nextPhaseStripePlanId = $phase['items'][0]['plan'];
                }
            }

            foreach ($previous_attributes['phases'] as $phase) {
                if ($stripeSubscriptionSchedule['current_phase']['end_date'] === $phase['start_date']) {
                    $previousNextPhaseStripePlanId = $phase['items'][0]['plan'];
                }
            }
            if (!isset($previousNextPhaseStripePlanId) || $nextPhaseStripePlanId !== $previousNextPhaseStripePlanId) {
                //next phase
                $nextPlan = $this->planRepository->getPlanByThirdPartyPlanId($nextPhaseStripePlanId);
                $this->userPlanService->scheduleNewUserPlan($user, $nextPlan);
            }
        }

        return $this->handleApiResponse();
    }

    /**
     * Handle invoice created
     *
     * @param array $stripeInvoice
     * @return array
     */
    public function handleInvoiceCreated(array $stripeInvoiceObject): array
    {
        $user = $this->userPaymentCustomerService->getUserByThirdPartyCustomerId($stripeInvoiceObject['customer']);
        $invoiceItems = [];
        foreach ($stripeInvoiceObject['lines']['data'] as $invoiceItem) {
            $invoiceItems[] = new InvoiceItem($invoiceItem['amount'], $invoiceItem['description'] ?: "");
        }

        $subscription = null;
        if ($stripeInvoiceObject['subscription'])
            $subscription = $this->subscriptionRepository->getSubscriptionByThirdPartyId($stripeInvoiceObject['subscription']);

        $invoice = new Invoice(
            $user->getUserPaymentCustomer(),
            $stripeInvoiceObject['id'],
            collect($invoiceItems),
            $stripeInvoiceObject['description'] ?: "",
            $subscription?->getId(),
            InvoiceStatus::Draft,
            $stripeInvoiceObject['auto_advance'],
            $stripeInvoiceObject['hosted_invoice_url']
        );
        $invoice->updateStatus(InvoiceStatus::translateFromStripe($stripeInvoiceObject['status']));
        $this->invoiceRepository->save($invoice);

        return $this->handleApiResponse();
    }

    /**
     * Handle invoice update
     *
     * @param array $stripeInvoice
     * @return array
     */
    public function handleInvoiceUpdated(array $stripeInvoiceObject): array
    {
        $invoice = $this->invoiceRepository->getInvoiceByThirdPartyInvoiceId($stripeInvoiceObject['id']);
        if (!$invoice) throw new Exception(__('api_message.invoice_not_found'));

        $invoice->getInvoiceItems()->each(function (InvoiceItem $invoiceItem, $key) use ($stripeInvoiceObject) {
            $invoiceItem->setAmount($stripeInvoiceObject['lines']['data'][$key]['amount']);
            $invoiceItem->setDescription($stripeInvoiceObject['lines']['data'][$key]['description'] ?: "");
        });

        $invoice->setDescription($stripeInvoiceObject['description'] ?: "");
        $invoice->updateStatus(InvoiceStatus::translateFromStripe($stripeInvoiceObject['status']));
        $invoice->setAutoAdvance($stripeInvoiceObject['auto_advance']);
        $invoice->setHostedInvoiceUrl($stripeInvoiceObject['hosted_invoice_url']);

        $this->invoiceRepository->save($invoice);

        return $this->handleApiResponse();
    }

    /**
     * Handle invoice paid
     *
     * @param array $stripeInvoice
     * @return array
     */
    public function handleInvoicePaid(array $stripeInvoiceObject): array
    {
        return $this->handleInvoiceUpdated($stripeInvoiceObject);
    }

    /**
     * Handle invoice item created
     *
     * @param array $stripeInvoiceItemObject
     * @return array
     */
    public function handleInvoiceitemCreated(array $stripeInvoiceItemObject): array
    {
        $invoice = $this->invoiceRepository->getInvoiceByThirdPartyInvoiceId($stripeInvoiceItemObject['invoice']);
        if (!$invoice) throw new Exception(__('api_message.invoice_not_found'));
        $invoiceItem = new InvoiceItem($stripeInvoiceItemObject['amount'], $stripeInvoiceItemObject['description']);

        $invoice->getInvoiceItems()->push($invoiceItem);
        $this->invoiceRepository->save($invoice);

        return $this->handleApiResponse();
    }

    /**
     * Format Registration data
     *
     * @return array
     */
    public function handleApiResponse(): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data
        ];
    }
}
