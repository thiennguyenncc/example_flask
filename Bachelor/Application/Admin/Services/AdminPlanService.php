<?php

namespace Bachelor\Application\Admin\Services;

use Bachelor\Domain\PaymentManagement\Plan\Interfaces\PlanRepositoryInterface;
use Illuminate\Http\Response;

class AdminPlanService
{
    /**
     * @var PlanRepositoryInterface
     */
    private $planRepository;

    /**
     * @var int
     */
    private $status;

    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $data = [];

    /**
     * AdminPlanService constructor.
     * @param PlanRepositoryInterface $planRepository
     */
    public function __construct(PlanRepositoryInterface $planRepository)
    {
        $this->planRepository = $planRepository;

        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
    }

    /**
     * Get All Plans
     *
     * @param int $perpage
     * @return array
     */
    public function getAllPlans(int $perpage): array
    {
        $this->data =  $this->planRepository->retrievePlanList($perpage);
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
