<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Admin;

use App\Http\Requests\AdminChangeUsersStatusRequest;
use App\Http\Requests\AdminFakeUserRequest;
use App\Http\Requests\AdminListUsersRequest;
use Bachelor\Application\Admin\Services\AdminUserService;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * @group User Administration
 */
class UserController extends BaseController
{
    public function __construct()
    {
        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
        $this->data = [];
    }

    /**
     * List users
     *
     * @param AdminListUsersRequest $request
     * @param AdminUserService $adminUserService
     * @return JsonResponse
     *
     * @queryParam page string Represent the page number in pagination
     * @queryParam name string Name of user
     * @queryParam gender integer Gender of user
     * @queryParam email email Email of user
     * @queryParam mobile_number string Mobile number of user
     * @queryParam status integer Status of user
     * @queryParam prefecture_id integer Prefecture id of user
     * @queryParam cost_plan string The plan to which the user is subscribed to
     * @queryParam is_fake integer User is fake or not. 1 = fake, 0 = real. Example: 1
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": {
     *        "current_page": 1,
     *        "data": [
     *            {
     *                "id": 2,
     *                "name": "u1",
     *                "gender": 1,
     *                "email": "u1@test.com",
     *                "mobile_number": null,
     *                "status": 4,
     *                "other_fields": null
     *            }, {
     *                "id": 3,
     *                "name": "u2",
     *                "gender": 2,
     *                "email": "u2@test.com",
     *                "mobile_number": null,
     *                "status": 4,
     *                "other_fields": null
     *            }
     *        ],
     *        "first_page_url": "http://bachelor.local/admin/user/list?page=1",
     *        "from": 1,
     *        "next_page_url": null,
     *        "path": "http://bachelor.local/admin/user/list",
     *        "per_page": 10,
     *        "prev_page_url": null,
     *        "to": 3
     *    }
     * }
     * @response 512 {
     *     "message":"Error encountered while getting user list data."
     *     "data":[]
     * }
     */
    public function listUsers(AdminListUsersRequest $request, AdminUserService $adminUserService)
    {
        $this->data = $adminUserService->listUsers(
            $request->get('search', ""),
            $request->get('gender'),
            $request->get('status'),
            $request->get('isFake'),
            $request->get('perPage', 50)
        );

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * View profile user
     *
     * @param int $userId
     * @param AdminUserService $adminUserService
     * @return JsonResponse
     */
    public function viewProfile(int $userId, AdminUserService $adminUserService)
    {
        $this->data = $adminUserService->getProfileUser($userId);

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * Update users status
     *
     * @param AdminChangeUsersStatusRequest $request
     * @param AdminUserService $adminUserService
     * @return JsonResponse
     *
     * @bodyParam userIds integer[] required Ids of users
     * @bodyParam status integer required Status need to update to
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": []
     * }
     * @response 512 {
     *     "message":"Error encountered while updating users status."
     *     "data":[]
     * }
     */
    public function updateStatus(AdminChangeUsersStatusRequest $request, AdminUserService $adminUserService)
    {
        DB::beginTransaction();
        try {
            $status = $request->get('status');
            $userIds = $request->get('userIds');

            switch ($status) {
                case UserStatus::ApprovedUser:
                    $this->data = $adminUserService->approveUsers($userIds);
                    break;
                case UserStatus::DeactivatedUser:
                    $this->data = $adminUserService->deactivateUsers($userIds);
                    break;
                case UserStatus::CancelledUser:
                    $this->data = $adminUserService->cancelUsers($userIds);
                    break;
                default:
                    throw new \Exception(__('admin_messages.user_status_not_found'));
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            throw $exception;
        }
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * Set fake user
     *
     * @param AdminFakeUserRequest $request
     * @param AdminUserService $adminUserService
     * @return JsonResponse
     *
     * @bodyParam userId integer required Id of user
     * @bodyParam fake integer required Is fake, 0 = real, 1 = fake. Example: 1
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": []
     * }
     * @response 512 {
     *     "message":"Error encountered while setting fake user."
     *     "data":[]
     * }
     */
    public function fakeUser(AdminFakeUserRequest $request, AdminUserService $adminUserService)
    {
        $adminUserService->setFakeUser(
            $request->get('userId'),
            $request->get('fake')
        );

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     *  Get user preferred areas
     *
     * @param Request $request
     * @param AdminUserService $prefectureService
     * @return JsonResponse
     *
     * @url admin/dating-places
     * @urlParam search string nullable Represent the search string
     * @urlParam filter array nullable Represent the filter param
     * @urlParam page integer nullable Represent the page number in pagination
     * @response 200 {
     *      "message" : "Successfully",
     *      "data" : [
     *          "message" : "Dating Place retrieved successfully",
     *          "areas" : []
     *      ]
     *  }
     * @response 512 {
     *      "message":"Error Encountered while retrieving dating place data in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/SmsController.php at 43 due to `Exception message`",
     *      "data":[]
     *  }
     */

    public function getUserPreferredPlaces(Request $request, AdminUserService $adminUserService): JsonResponse
    {
        // Retrieve dating place data
        $this->data =  $adminUserService->getUserPreferredAreaData($request->all());

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }


    /**
     * @param Request $request
     * @param AdminUserService $adminUserService
     * @return JsonResponse
     */
    public function uploadBulkApprovalCsv(Request $request, AdminUserService $adminUserService): JsonResponse
    {
        $uploadedFilePath = $request->file('bulk_file');
        $this->data = $adminUserService->bulkApprovalFromFile($uploadedFilePath);

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }
}
