<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Admin;

use App\Http\Requests\AdminRequest;
use App\Http\Requests\CreateParticipantRecommendationSettingRequest;
use Bachelor\Application\Admin\Services\AdminParticipantAwaitingCancelSettingService;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Illuminate\Http\JsonResponse;

/**
 * @group Dating
 */
class ParticipantAwaitingCancelSettingController extends BaseController
{
    /**
     * Get awaiting cancels
     *
     * @param AdminRequest $request
     * @param AdminParticipantAwaitingCancelSettingService $adminParticipantAwaitingCancelSettingService
     * @urlParam dating_day_id string or int nullable key for filter awaiting cancel list by dating_day_id column
     * @urlParam gender string or int nullable key for filter awaiting cancel list by gender column
     * @return JsonResponse
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": [
     *        [
     *            {
     *                "dating_day_id": 1,
     *                "dating_date": "2020-12-15",
     *                "gender": 1,
     *                "days_before": 1,
     *                "ratio": 0.5
     *            }, {
     *                "dating_day_id": 1,
     *                "dating_date": "2020-12-15",
     *                "gender": 2,
     *                "days_before": 2,
     *                "ratio": 0.7
     *            }
     *        ],
     *        [
     *            {
     *                "dating_day_id": 2,
     *                "dating_date": "2020-12-17",
     *                "gender": 1,
     *                "days_before": 2,
     *                "ratio": 1
     *            }
     *        ]
     *    ]
     * }
     * @response 512 {
     *  "message":"Error encountered while getting awaiting cancels."
     *  "data":[]
     * }
     */
    public function getAwatingCancels(AdminRequest $request, AdminParticipantAwaitingCancelSettingService $adminParticipantAwaitingCancelSettingService)
    {
        $response = $adminParticipantAwaitingCancelSettingService->getAwaitingCancels($request->all())->handleApiResponse();

        self::setResponse($response['status'], $response['message'], $response['data']);
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * Add new awaiting cancels
     *
     * @param CreateParticipantRecommendationSettingRequest $request
     * @param AdminParticipantAwaitingCancelSettingService $adminParticipantAwaitingCancelSettingService
     * @return JsonResponse
     *
     * @bodyParam dateId integer required ID of Matching Date
     * @bodyParam gender integer required Gender, 1 = Male, 2 = Female
     * @bodyParam ratio[].daysBefore integer required Days before matching day
     * @bodyParam ratio[].ratio float required Ratio of that day
     *
     * @response 200 {
     *  "message": "Successful",
     *  "data": []
     * }
     * @response 512 {
     *  "message":"Error encountered while adding awaiting cancels."
     *  "data":[]
     * }
     */
    public function setAwaitingCancels(CreateParticipantRecommendationSettingRequest $request, AdminParticipantAwaitingCancelSettingService $adminParticipantAwaitingCancelSettingService)
    {
        $response = $adminParticipantAwaitingCancelSettingService->setAwaitingCancels(
            $request->get('dateId'),
            $request->get('gender'),
            $request->get('ratio'),
        )->handleApiResponse();

        self::setResponse($response['status'], $response['message'], $response['data']);
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

}
