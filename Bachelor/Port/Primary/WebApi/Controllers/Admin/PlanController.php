<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Admin;

use Bachelor\Application\Admin\Services\AdminPlanService;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class SchoolController
 * @package Bachelor\Port\Primary\WebApi\Controllers\Admin
 *
 * @group Match School Setting
 */
class PlanController extends BaseController
{
    /**
     * Get all Plans
     *
     * @url admin/plan/
     * @method GET
     * @response 200 {
     *      "message" : "Successfully",
     *      "data": [
     *           {
     *          },
     *          .....
     *      ]
     *  }
     * @response 512 {
     *       "message": "Error Encountered while retrieving plans in /Users/yamanemizuki/Github/bachelor-backend/Bachelor/Port/Primary/WebApi/Controllers/Admin/PlanController.php at 52 due to Exeption",
     *     "data": []
     *   }
     *
     * @param AdminPlanService $planService
     * @return JsonResponse
     */
    public function getAllPlans(Request $request, AdminPlanService $planService)
    {
        // Retrieve all plans
        $response = $planService->getAllPlans($request->get('perPage', 0));

        // Set api response
        $this->setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }
}
