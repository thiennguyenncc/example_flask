<?php

namespace Bachelor\Application\User\Services;

use Bachelor\Domain\PaymentManagement\Plan\Enum\CostPlan;
use Bachelor\Domain\PaymentManagement\Plan\Events\DowngradePlan;
use Bachelor\Domain\PaymentManagement\Plan\Events\UpgradePlan;
use Bachelor\Domain\PaymentManagement\UserPlan\Interfaces\UserPlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\UserTrial\Enum\TrialStatus;
use Bachelor\Domain\PaymentManagement\Plan\Interfaces\PlanRepositoryInterface;
use Bachelor\Domain\PaymentManagement\Plan\Models\Plan;
use Bachelor\Domain\PaymentManagement\UserPlan\Services\UserPlanService;
use Bachelor\Domain\PaymentManagement\UserTrial\Interfaces\UserTrialRepositoryInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserPlanApplicationService
{
    /**
     * Response Status
     */
    protected $status;

    /**
     * Response Message
     */
    protected $message;

    /*
     * Response data
     *
     * @var array
     */
    protected $data = [];

    protected PlanRepositoryInterface $planRepository;

    private UserPlanService $userPlanService;

    private UserTrialRepositoryInterface $userTrialRepository;

    private UserPlanRepositoryInterface $userPlanRepository;

    /**
     * UserPlanApplicationService constructor.
     */
    public function __construct(
        PlanRepositoryInterface $planRepository,
        UserPlanService $userPlanService,
        UserTrialRepositoryInterface $userTrialRepository,
        UserPlanRepositoryInterface $userPlanRepository
    ) {
        $this->planRepository = $planRepository;
        $this->userPlanService = $userPlanService;
        $this->userTrialRepository = $userTrialRepository;
        $this->userPlanRepository = $userPlanRepository;
        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
    }

    /**
     * Retrieve plan change data for the user
     *
     * @return array
     */
    public function getPlans(array $params): array
    {
        $collection = $this->planRepository->getPlanCollection(
            $params['discountType'] ?? null,
            $params['costPlan'] ?? null,
            $params['contractTerm'] ?? null
        );

        $this->data = $collection->transform(function (Plan $plan) {
            return [
                'id' => $plan->getId(),
                'name' => $plan->getName(),
                'price' => $plan->getFinalAmount(),
                'discountType' => $plan->getDiscountType(),
                'costPlan' => $plan->getCostPlanKey(),
                'contractTerm' => $plan->getContractTerm(),
                'cost_plan_name' => $plan->getCostPlan()->getName(),
            ];
        })->toArray();

        return $this->handleApiResponse();
    }

    /**
     * Initiate the user plan change
     *
     * @param array $params
     * @return array
     */
    public function changePlan(int $plan_id): array
    {
        $user = Auth::user()->getDomainEntity();

        $newPlan = $this->planRepository->getPlanById($plan_id);
        $userPlan = $this->userPlanRepository->getActiveUserPlanByUserId($user->getId());
        $currentPlan = $userPlan->getPlan();
        $userTrial = $this->userTrialRepository->getLatestTrialByUser($user);

        if ($userTrial->getStatus() === TrialStatus::Completed) {
            $isChangePlan = $this->userPlanService->scheduleNextPlan($user, $newPlan);
        } else {
            $isChangePlan = $this->userPlanService->startNewActivePlan($user, $newPlan);
        }
        if ($isChangePlan && $newPlan->getCostPlan()->isUpgradeThan($currentPlan->getCostPlan())) {
            UpgradePlan::dispatch($user, $newPlan);
        } elseif ($isChangePlan && $newPlan->getCostPlan()->isDowngradeThan($currentPlan->getCostPlan())) {
            DowngradePlan::dispatch($user, $newPlan, $currentPlan);
        }

        return $this->handleApiResponse();
    }

    /**
     * Format response data
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
