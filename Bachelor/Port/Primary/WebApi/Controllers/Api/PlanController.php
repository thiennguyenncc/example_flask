<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Api;

use App\Http\Requests\User\Plan\PlanChangeRequest;
use App\Http\Requests\User\Plan\PlanRequest;
use Bachelor\Application\User\Services\UserPlanApplicationService;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

/**
 * Class PlanController
 * @package Bachelor\Port\Primary\WebApi\Controllers\Api
 *
 * @group Plan Change
 */
class PlanController extends BaseController
{
    /**
     * Retrieve user plan change data
     *
     * @param UserPlanApplicationService $userPlanService
     * @return JsonResponse
     */
    public function getPlan(PlanRequest $request, UserPlanApplicationService $userPlanService): JsonResponse
    {
        $response = $userPlanService->getPlans($request->all());

        // set api response
        $this->setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }

    /**
     * Initiate plan change
     *
     * @param PlanChangeRequest $request
     * @param UserPlanApplicationService $userPlanService
     * @return JsonResponse
     */
    public function changePlan(UserPlanApplicationService $userPlanService, int $plan_id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $response = $userPlanService->changePlan($plan_id);

            DB::commit();

            // set api response
            $this->setResponse($response['status'], $response['message'], $response['data']);
        } catch (Exception $exception) {

            DB::rollback();
            throw $exception;
        }

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }
}
