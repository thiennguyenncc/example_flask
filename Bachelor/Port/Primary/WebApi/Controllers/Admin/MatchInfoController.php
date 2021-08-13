<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Admin;

use App\Http\Requests\Admin\MatchInfo\MatchInfoCreateRequest;
use App\Http\Requests\Admin\MatchInfo\MatchInfoUpdateRequest;
use Bachelor\Application\Admin\Services\AdminMatchInfoService;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Illuminate\Http\JsonResponse;

/**
 * Class MatchProfileController
 * @package Bachelor\Port\Primary\WebApi\Controllers\Admin
 *
 * @group Match Profile Setting
 */
class MatchInfoController extends BaseController
{
    /**
     * Get all profiles
     *
     * @url admin/match-profile/profile/
     * @method GET
     *
     * @response 200 {
     *      "message" : "Successfully",
     *      "data": [
     *           {
     *              "id": 3,
     *              "group_id": 4,
     *              "description": "example",
     *              "image": "example.jpg"
     *          },
     *          .....
     *      ]
     *  }
     * @response 512 {
     *       "message": "Error Encountered while retrieving profiles in /Users/yamanemizuki/Github/bachelor-backend/Bachelor/Port/Primary/WebApi/Controllers/Admin/MatchProfileController.php at 52 due to Exeption",
     *     "data": []
     *   }
     *
     * @param AdminMatchInfoService $matchInfoService
     * @return JsonResponse
     */
    public function getAllInfos(AdminMatchInfoService $matchInfoService)
    {
        // Retrieve all profiles
        $response = $matchInfoService->getAllInfos()
            ->handleApiResponse();

        // Set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }


    /**
     * Create new a profile
     *
     * @url admin/match-profile/profile/
     * @method POST
     * @bodyParam group_id int required Group which profile belongs to
     * @bodyParam description string required Profile description
     * @bodyParam image image required image of profile
     * @response 200 {
     *      "message" : "Successfully",
     *      "data": []
     *  }
     * @response 512 {
     *     "message": {
     *         "description": [
     *             "The description field is required."
     *         ]
     *     },
     *     "data": []
     * }
     *
     * @param Match ProfileRequest $request
     * @param AdminMatchInfoService $matchInfoService
     * @return JsonResponse
     */
    public function createGroupAndInfo(MatchInfoCreateRequest $request, AdminMatchInfoService $matchInfoService)
    {
        // create new profile
        $response = $matchInfoService->createGroupAndInfo($request->all())
        ->handleApiResponse();

        // Set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }

    /**
     * Update an existing profile
     *
     * @url admin/match-profile/profile/{id}
     * @method PUT
     * @routeParam id required Id of profile
     * @bodyParam group_id int required Group which profile belongs to
     * @bodyParam description string required Profile description
     * @bodyParam image image required image of profile
     * @response 200 {
     *      "message" : "Successfully",
     *      "data": []
     *  }
     * @response 512 {
     *     "message": {
     *         "description": [
     *             "The description field is required."
     *         ]
     *     },
     *     "data": []
     * }
     *
     * @param MatchProfileRequest $request
     * @param AdminMatchInfoService $matchInfoService
     * @param string $id
     * @return JsonResponse
     */
    public function updateInfo(MatchInfoUpdateRequest $request, AdminMatchInfoService $matchInfoService, int $id)
    {
        // update an existing profile
        $response = $matchInfoService->updateInfo($id, $request->all())
        ->handleApiResponse();

        // Set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }

    /**
     * Delete an existing profile
     *
     * @url admin/match-profile/profile/{id}
     * @method DELETE
     * @routeParam id required Id of profile
     * @response 200 {
     *      "message" : "Successfully",
     *      "data": []
     *  }
     * @response 512 {
     *   "message": "Error Encountered while deleting profile id: 12 in /Users/yamanemizuki/Github/bachelor-backend/Bachelor/Application/Admin/Services/AdminMatchInfoService.php at 92 due to admin_messages.failed_to_delete_match_profile",
     *    "data": []
     *   }
     *
     * @param AdminMatchInfoService $matchInfoService
     * @param string $id
     * @return JsonResponse
     */
    public function deleteGroup(AdminMatchInfoService $matchInfoService, int $id)
    {
        // delete an existing profile
        $response = $matchInfoService->deleteGroup($id)
        ->handleApiResponse();

        // Set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }
}
