<?php

namespace Bachelor\Application\User\Services;

use Bachelor\Domain\Base\Exception\BaseValidationException;
use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Interfaces\ParticipantMainMatchRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Invoice\Services\InvoiceService;
use Bachelor\Domain\PaymentManagement\PaymentCard\Enum\ValidationMessages;
use Bachelor\Domain\PaymentManagement\PaymentCard\Events\StoredNewCard;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use Bachelor\Domain\PaymentManagement\PaymentCard\Interfaces\PaymentCardInterface;
use Bachelor\Domain\PaymentManagement\PaymentCard\Models\PaymentCard;
use Bachelor\Domain\PaymentManagement\PaymentProvider\Enum\PaymentGateway;
use Bachelor\Domain\PaymentManagement\PaymentProvider\Interfaces\PaymentProviderRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Interfaces\ExtPaymentCustomerRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Interfaces\UserPaymentCustomerRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPaymentCustomer\Models\UserPaymentCustomer;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\UserPlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserPlan\Services\UserPlanService;
use Bachelor\Domain\PaymentManagement\UserTrial\Interfaces\UserTrialRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Services\UserTrialService;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Port\Primary\WebApi\Traits\HandleResponse;
use Bachelor\Port\Secondary\Database\UserManagement\User\Repository\UserRepository;
use Bachelor\Utility\Helpers\Utility;

class PaymentCardService
{
    use HandleResponse;

    /**
     * User Card interface
     *
     * @var PaymentCardInterface
     */
    private $paymentCardRepository;

    /**
     * ExtPaymentCustomerRepositoryInterface
     *
     * @var ExtPaymentCustomerRepositoryInterface
     */
    private $externalPaymentCustomerRepository;

    /**
     * PaymentProviderRepository
     *
     * @var PaymentProviderRepositoryInterface
     */
    private $paymentProviderRepository;

    /**
     * UserPaymentCustomerRepositoryInterface
     *
     * @var UserPaymentCustomerRepositoryInterface
     */
    private $userPaymentCustomerRepository;

    private UserTrialService $userTrialService;
    private UserPlanService $userPlanService;
    private InvoiceService $invoiceService;
    private UserRepository $userRepository;
    private ParticipantMainMatchRepositoryInterface $participantMainMatchRepository;
    private UserPlanRepositoryInterface $userPlanRepository;
    private UserTrialRepositoryInterface $userTrialRepository;

    /**
     * Response Status
     */
    protected $status;

    /**
     * Response Message
     */
    protected $message;

    /**
     * Response data
     *
     * @var array
     */
    protected $data = [];

    /**
     * User
     *
     * @var User
     */
    protected User $user;

    /**
     * User card service interface
     *
     * @param PaymentCardInterface $paymentCardRepository
     * @param ExtPaymentCustomerRepositoryInterface $externalPaymentCustomerRepository
     * @param PaymentProviderRepositoryInterface $paymentProviderRepository
     * @param UserPaymentCustomerRepositoryInterface $userPaymentCustomerRepository
     * @param UserRepository $userRepository
     * @param ParticipantMainMatchRepositoryInterface $participantMainMatchRepository
     * @param UserPlanRepositoryInterface $userPlanRepository
     */
    public function __construct(
        PaymentCardInterface $paymentCardRepository,
        ExtPaymentCustomerRepositoryInterface $externalPaymentCustomerRepository,
        PaymentProviderRepositoryInterface $paymentProviderRepository,
        UserPaymentCustomerRepositoryInterface $userPaymentCustomerRepository,
        UserTrialService $userTrialService,
        UserPlanService $userPlanService,
        InvoiceService $invoiceService,
        UserRepository $userRepository,
        ParticipantMainMatchRepositoryInterface $participantMainMatchRepository,
        UserPlanRepositoryInterface $userPlanRepository,
        UserTrialRepositoryInterface $userTrialRepository,
    ) {
        $this->paymentCardRepository = $paymentCardRepository;
        $this->externalPaymentCustomerRepository = $externalPaymentCustomerRepository;
        $this->paymentProviderRepository = $paymentProviderRepository;
        $this->userPaymentCustomerRepository = $userPaymentCustomerRepository;
        $this->userTrialService = $userTrialService;
        $this->userPlanService = $userPlanService;
        $this->invoiceService = $invoiceService;
        $this->userRepository = $userRepository;
        $this->participantMainMatchRepository = $participantMainMatchRepository;
        $this->userPlanRepository = $userPlanRepository;
        $this->userTrialRepository = $userTrialRepository;

        $this->user = Auth::user()->getDomainEntity();
        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
    }

    /**
     * Get user cards
     *
     * @return array
     */
    public function getUserCards(): array
    {
        $paymentCardCollection = $this->paymentCardRepository->getPaymentCardCollectionByUser($this->user);
        $this->data = $paymentCardCollection->transform(function (PaymentCard $paymentCard) {
            return [
                'id' => $paymentCard->getId(),
                'lastFourDigits' => $paymentCard->getLastFourDigits(),
                'isPrimary' => ($this->user->getUserPaymentCustomer()->getDefaultPaymentCard()->getId() === $paymentCard->getId())
            ];
        })->toArray();
        $this->message = __('api_messages.paymentCard.successfully_list_user_cards');

        return $this->handleApiResponse();
    }

    /**
     * Create new credit card
     *
     * @param array $params
     * @return array
     * @throws Exception
     */
    public function storeNewPaymentCard(array $params): array
    {
        $userPaymentCustomer = $this->user->getUserPaymentCustomer();
        if (!$userPaymentCustomer) {
            $paymentProvider = $this->paymentProviderRepository->getPaymentProviderByName(PaymentGateway::Stripe);
            $thirdPartyCustomerId = $this->externalPaymentCustomerRepository->createCustomer($this->user, $params['sourceToken']);

            $userPaymentCustomer = new UserPaymentCustomer($this->user->getId(), $thirdPartyCustomerId, $paymentProvider);
            $this->userPaymentCustomerRepository->save($userPaymentCustomer);

            $defaultCardInfo = $this->externalPaymentCustomerRepository->retrieveDefaultSourceInfo($userPaymentCustomer);
            $paymentCard = new PaymentCard(
                $userPaymentCustomer->getId(),
                $defaultCardInfo['id'],
                $defaultCardInfo['last4']
            );
            $this->paymentCardRepository->save($paymentCard);
        } else {
            $cardId = $this->externalPaymentCustomerRepository->storeCustomerSource($userPaymentCustomer, $params['sourceToken']);

            $paymentCard = Utility::wait(
                function () use ($cardId) {
                    return $this->paymentCardRepository->getPaymentCardByThirdPartyCardId($cardId);
                }
            );

            if ($paymentCard) {
                $this->externalPaymentCustomerRepository->updateDefaultSource($this->user->getUserPaymentCustomer(), $paymentCard);
            }
            //re-attempt open and unCollectible invoices
            $this->invoiceService->retryPaymentForUnpaidInvoice($this->user);
        }

        StoredNewCard::dispatch($this->user);

        $awaitingParticipations = $this->participantMainMatchRepository->getAwaitingForUser($this->user);
        $activeUserPlan = $this->userPlanRepository->getActiveUserPlanByUserId($this->user->getId());
        $activeTrial = $this->userTrialRepository->getLatestUserTrialByUserIfActive($this->user);
        $this->data = [
            "has_participation" => $awaitingParticipations->isNotEmpty(),
            "cost_plan_name" => $activeUserPlan?->getPlan()->getCostPlan()->getName(),
            "cost_plan_monthly_fee" => $activeUserPlan?->getPlan()->getFinalAmount(),
            "cost_plan_per_dating_fee" => $activeUserPlan?->getPlan()->getAmountPerDating(),
            "trial_end" => $activeTrial?->getTrialEnd(),
        ];

        return $this->handleApiResponse();
    }

    /**
     * Set card as default card
     *
     * @param int $cardId
     * @return array
     */
    public function setDefaultPaymentCard(int $cardId): array
    {
        // Get card details
        $paymentCard = $this->paymentCardRepository->getPaymentCardById($cardId);
        if (!$paymentCard) throw BaseValidationException::withMessages(ValidationMessages::InvalidCard);

        $this->externalPaymentCustomerRepository->updateDefaultSource($this->user->getUserPaymentCustomer(), $paymentCard);

        Utility::wait(
            function () use ($cardId) {
                $userPaymentCustomer = $this->userPaymentCustomerRepository->getUserPaymentCustomerByUserId($this->user->getId());
                return ($userPaymentCustomer->getDefaultPaymentCard()->getId() === $cardId);
            }
        );

        return $this->handleApiResponse();
    }

    /**
     * Delete user card
     *
     * @param int $cardId
     * @return array
     */
    public function deleteUserCard(int $cardId): array
    {
        // Get card details
        $paymentCard = $this->paymentCardRepository->getPaymentCardById($cardId);
        $userPaymentCustomer = $this->user->userPaymentCustomer();

        // if card not found
        if (!$paymentCard) throw BaseValidationException::withMessages(ValidationMessages::InvalidCard);
        //cannot delete primary card
        if ($userPaymentCustomer->getDefaultPaymentCard()->getId() === $paymentCard->getId())
            throw BaseValidationException::withMessages(ValidationMessages::CannotDeletePrimaryCard);

        $this->externalPaymentCustomerRepository->deleteCustomerSource($userPaymentCustomer, $paymentCard);

        return $this->handleApiResponse();
    }
}
