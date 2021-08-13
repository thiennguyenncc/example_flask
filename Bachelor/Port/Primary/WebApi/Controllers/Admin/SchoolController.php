<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Admin;

use App\Http\Requests\Admin\SchoolRequest;
use Bachelor\Application\Admin\Services\AdminSchoolService;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Class SchoolController
 * @package Bachelor\Port\Primary\WebApi\Controllers\Admin
 *
 * @group Match School Setting
 */
class SchoolController extends BaseController
{
    /**
     * Get all schools
     *
     * @url admin/school/
     * @method GET
     * @response 200 {
     *      "message" : "Successfully",
     *      "data": [
     *           {
     *              "id": 3,
     *              "school_name": "school_name",
     *              "education_group": 5
     *          },
     *          .....
     *      ]
     *  }
     * @response 512 {
     *       "message": "Error Encountered while retrieving schools in /Users/yamanemizuki/Github/bachelor-backend/Bachelor/Port/Primary/WebApi/Controllers/Admin/SchoolController.php at 52 due to Exeption",
     *     "data": []
     *   }
     *
     * @param AdminSchoolService $schoolService
     * @return JsonResponse
     */
    public function getAllSchools(SchoolRequest $request, AdminSchoolService $schoolService)
    {
        // Retrieve all schools
        $response = $schoolService->getAllSchools($request->all());

        // Set api response
        $this->setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }


    /**
     * Create new a school
     *
     * @url admin/school/
     * @method POST
     * @bodyParam school_name string required School name
     * @bodyParam education_group int required Education Group which school belongs to
     * @response 200 {
     *      "message" : "Successfully",
     *      "data": []
     *  }
     * @response 512 {
     *     "message": {
     *         "school_name": [
     *             "The school_name field is required."
     *         ]
     *     },
     *     "data": []
     * }
     *
     * @param Match SchoolRequest $request
     * @param AdminSchoolService $schoolService
     * @return JsonResponse
     */
    public function createSchool(SchoolRequest $request, AdminSchoolService $schoolService)
    {
        // create new school
        $response = $schoolService->createNewSchool($request->all());

        // Set api responsex
        $this->setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }

    /**
     * Update an existing school
     *
     * @url admin/school/{id}
     * @method PUT
     * @bodyParam id int required School Id
     * @bodyParam school_name string required School name
     * @bodyParam education_group int required Education Group which school belongs to
     * @response 200 {
     *      "message" : "Successfully",
     *      "data": []
     *  }
     * @response 512 {
     *     "message": {
     *         "school_name": [
     *             "The school_name field is required."
     *         ]
     *     },
     *     "data": []
     * }
     *
     * @param SchoolRequest $request
     * @param AdminSchoolService $schoolService
     * @param string $id
     * @return JsonResponse
     */
    public function updateSchool(SchoolRequest $request, AdminSchoolService $schoolService, int $id)
    {
        // update an existing school
        $response = $schoolService->updateSchool($id, $request->all());

        // Set api response
        $this->setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }

    /**
     * Delete an existing school
     *
     * @url admin/school/{id}
     * @method DELETE
     * @routeParam id required Id of school
     * @response 200 {
     *      "message" : "Successfully",
     *      "data": []
     *  }
     * @response 512 {
     *   "message": "Error Encountered while deleting school id: 12 in /Users/yamanemizuki/Github/bachelor-backend/Bachelor/Application/Admin/Services/AdminSchoolService.php at 92 due to admin_messages.failed_to_delete_school",
     *    "data": []
     *   }
     *
     * @param AdminSchoolService $schoolService
     * @param string $id
     * @return JsonResponse
     */
    public function deleteSchool(AdminSchoolService $schoolService, int $id)
    {
        // delete an existing school
        $response = $schoolService->deleteSchool($id);

        // Set api response
        $this->setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }
}
