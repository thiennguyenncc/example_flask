<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Admin;

use App\Http\Requests\AdminRequest;
use App\Http\Requests\ParticipantMigrationRequest;
use Bachelor\Application\Admin\Services\AdminParticipantService;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Participants
 */
class ParticipantController extends BaseController
{
    /**
     * Get list of participants
     *
     * @param AdminRequest $request
     * @param AdminParticipantService $participantService
     * @return JsonResponse
     *
     * @queryParam day string required The day need to get participant list, monday - sunday. Example: wednesday
     * @queryParam page integer nullable Represent the page number in pagination
     *
     * @response 200 {
     *  "current_page": 1,
     *  "data": [
     *    {
     *      "user_id": 1,
     *      "matching_dates": [
     *        {
     *          "id": 1,
     *          "matching_day": "tuesday",
     *          "matching_date": "2020-12-15"
     *        }, {
     *          "id": 3,
     *          "matching_day": "saturday",
     *          "matching_date": "2020-12-26"
     *        }
     *      ]
     *    },
     *  ],
     *  "first_page_url": "http://bachelor.com/admin/participant/list?page=1",
     *  "from": 1,
     *  "next_page_url": null,
     *  "path": "http://bachelor.com/admin/participant/list",
     *  "per_page": 10,
     *  "prev_page_url": null,
     *  "to": 4
     * }
     *
     * @response 512 {
     *     "message":"Error Encountered while retrieving participant data"
     *     "data":[]
     * }
     */
    public function listParticipants(AdminRequest $request, AdminParticipantService $participantService): JsonResponse
    {
        $response = $participantService->listAwaitingParticipants()->handleApiResponse();

        self::setResponse($response['status'], $response['message'], $response['data']);
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * Import participants from CSV file
     *
     * @param ParticipantMigrationRequest $request
     * @param AdminParticipantService $participantService
     * @return JsonResponse
     *
     * @bodyParam migration_file file required CSV file need to be uploaded
     *
     * @response 200 {
     *  "message": "Successful",
     *  "data": {
     *    "aborted": [
     *      {
     *        "user_id": 3,
     *        "matching_day": "thursday",
     *        "reason": "Matching day not valid or has not been created"
     *      }, {
     *        "user_id": 4,
     *        "matching_day": "friday",
     *        "reason": "User not found"
     *      }
     *    ],
     *    "imported": 2,
     *    "failed_import": 0
     *  }
     * }
     * @response 512 {
     *     "message":"Error Encountered while retrieving data"
     *     "data":[]
     * }
     */
    public function migrateMainMatchingParticipants(ParticipantMigrationRequest $request, AdminParticipantService $participantService)
    {
        $response = $participantService->migrateMainMatchingParticipants($request->file('migration_file')->getRealPath())->handleApiResponse();

        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * @param Request $request
     * @param AdminParticipantService $participantService
     * @return JsonResponse
     *
     * @response 200 {
     *  "message": "Successful",
     *  "data": []
     * }
     * @response 512 {
     *  "message":"Error encountered while resetting data.,
     *  "data":[]
     * }
     */
    public function resetDatingAndParticipant(Request $request, AdminParticipantService $participantService)
    {
        $response = $participantService->resetDatingAndParticipant()->handleApiResponse();
        self::setResponse($response['status'], $response['message'], $response['data']);
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }
}
