<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Admin;

use App\Http\Requests\Admin\Dating\CancelDatingRequest;
use App\Http\Requests\Admin\Dating\MatchedPairList;
use App\Http\Requests\AdminMatchingDateSettingRequest;
use App\Http\Requests\AdminRequest;
use App\Http\Requests\CreateParticipantRecommendationSettingRequest;
use App\Http\Requests\AdminRematchingRequest;
use App\Http\Requests\MatchedUserPairList\MatchedUserPairListRequest;
use Bachelor\Application\Admin\Services\AdminDatingService;
use Bachelor\Application\Admin\Services\AdminParticipantRecommendationSettingService;
use Bachelor\Application\Admin\Services\Interfaces\AdminDatingServiceInterface;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Dating
 */
class DatingController extends BaseController
{
    /**
     * Rematching
     *
     * @param AdminRematchingRequest $request
     * @param AdminDatingServiceInterface $adminDatingService
     * @return JsonResponse
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": {
     *        "aborted": [
     *            {
     *                "user_id": 22,
     *                "type": "12pm",
     *                "date": "2020-09-20",
     *                "reason": "User not found."
     *            }
     *        ],
     *        "imported": 4,
     *        "failed_import": 0
     *    }
     * }
     * @response 512 {
     *     "message":"Error encountered while importing rematch data."
     *     "data":[]
     * }
     */
    public function rematch(AdminRematchingRequest $request, AdminDatingServiceInterface $adminDatingService)
    {
        $uploadedFile = $request->file('rematching_file');
        $response = $adminDatingService->rematchFromFile($uploadedFile->getRealPath())->handleApiResponse();

        self::setResponse($response['status'], $response['message'], $response['data']);
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * Get dating day for matching
     *
     * @param Request $request
     * @param AdminDatingService $adminDatingService
     * @return JsonResponse
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": {
     *        "data": [
     *            {
     *                "id": 1,
     *                "dating_date": '2021-04-14',
     *                "dating_day": 'wednesday',
     *                "user_status": {1,2,3}
     *            }
     *        ],
     *    }
     * }
     * @response 512 {
     *  "message":"Error encountered while getting dating days."
     *  "data":[]
     * }
     */
    public function getDatingDay(AdminDatingService $adminDatingService): JsonResponse
    {
        $response = $adminDatingService->getDatingDay()->handleApiResponse();

        self::setResponse($response['status'], $response['message'], $response['data']);
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * Get dating day of week settings
     *
     * @param Request $request
     * @param AdminDatingServiceInterface $adminDatingService
     * @return JsonResponse
     *
     * @queryParam page integer nullable Represent the page number in pagination
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": {
     *        "current_page": 1,
     *        "data": [
     *            {
     *                "id": 1,
     *                "dating_day_id": 1,
     *                "user_status": {1,2,3}
     *            }
     *        ],
     *    }
     * }
     * @response 512 {
     *  "message":"Error encountered while getting dates."
     *  "data":[]
     * }
     */
    public function getDatingDayOfWeekSetting(Request $request, AdminDatingServiceInterface $adminDatingService): JsonResponse
    {
        $response = $adminDatingService->getDatingDayOfWeekSetting($request->all())->handleApiResponse();

        self::setResponse($response['status'], $response['message'], $response['data']);
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * create or update participation open closed expired setting data
     *
     * @param AdminMatchingDateSettingRequest $request
     * @param AdminDatingServiceInterface $adminDatingService
     *
     * @bodyParam userGender integer gender of user setting
     * @bodyParam wednesdaySecondFormCompletedOpenDay integer required time to open (3 ~ 20)
     * @bodyParam wednesdaySecondFormCompletedExpireDay integer required time to open (0 ~ 19)
     * @bodyParam wednesdaySecondFormInCompletedOpenDay integer required time to expire (3 ~ 20)
     * @bodyParam wednesdaySecondFormInCompletedExpireDay integer required time to expire (0 ~ 19)
     *
     *
     * @bodyParam saturdaySecondFormCompletedOpenDay integer required time to open (3 ~ 20)
     * @bodyParam saturdaySecondFormCompletedExpireDay integer required time to open (0 ~ 19)
     * @bodyParam saturdaySecondFormInCompletedOpenDay integer required time to expire (3 ~ 20)
     * @bodyParam saturdaySecondFormInCompletedExpireDay integer required time to expire (0 ~ 19)
     *
     *
     * @bodyParam sundaySecondFormCompletedOpenDay integer required time to open (3 ~ 20)
     * @bodyParam sundaySecondFormCompletedExpireDay integer required time to open (0 ~ 19)
     * @bodyParam sundaySecondFormInCompletedOpenDay integer required time to expire (3 ~ 20)
     * @bodyParam sundaySecondFormInCompletedExpireDay integer required time to expire (0 ~ 19)
     *
     * @return JsonResponse
     *
     * @response 200 {
     *  "message": "Successful",
     *  "data": []
     * }
     * @response 512 {
     *  "message":"Error encountered while updating status."
     *  "data":[]
     * }
     */
    public function createOrUpdateDatingDayOfWeekSetting(AdminMatchingDateSettingRequest $request, AdminDatingServiceInterface $adminDatingService)
    {
        $response = $adminDatingService->createOrUpdateDatingDayOfWeekSetting($request->all())->handleApiResponse();

        self::setResponse($response['status'], $response['message'], $response['data']);
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    //matched user pair list

    /**
     *  Get all the prefectures
     *
     * @param MatchedPairList $request
     * @param AdminDatingService $adminDatingService
     * @return JsonResponse
     *
     * @url /admin/prefectures
     * @urlParam weekOffSet int nullable Represent the limit data of dating by weekoffset. Example: 0
     * @urlParam status int nullable Represent the filter param. Example: "status" : 1
     * @response 200 {
     *      "message" : "Successfully",
     *      "data" : [
     *          "message" : "Prefecture retrieved successfully",
     *          "data" : []
     *      ]
     *  }
     * @response 512 {
     *      "message":"Error Encountered while retrieving prefecture data data in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/SmsController.php at 43 due to `Exception message`",
     *      "data":[]
     *  }
     */
    public function getDatingHistory(MatchedPairList $request, AdminDatingService $adminDatingService): JsonResponse
    {
        $response = $adminDatingService->getDatingHistory(
            $request->get('weekOffSet', 4),
            $request->get('status', 1),
            $request->get('search', ""),
            $request->get('isFake', null),
            $request->get('datingDate', null),
            $request->get('startTime', null),
            )->handleApiResponse();
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * create matching date
     *
     * @param MatchedUserPairListRequest $request
     * @param AdminDatingService $adminDatingService
     * @return JsonResponse
     *
     * @bodyParam male integer required id of male user
     * @bodyParam female integer required id of female user
     * @bodyParam area integer required id of area user
     * @bodyParam cafe integer required id of cafe user
     * @bodyParam date integer required id of matching_date user
     * @bodyParam time time required time to date
     *
     * @response 200 {
     *  "message": "Successful",
     *  "data": []
     * }
     * @response 512 {
     *  "message":"Error encountered while updating status."
     *  "data":[]
     * }
     */
    public function createMatchedPairList(MatchedUserPairListRequest $request, AdminDatingService $adminDatingService)
    {
        $response = $adminDatingService->createDating($request->all())->handleApiResponse();

        self::setResponse($response['status'], $response['message'], $response['data']);
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * get matching date data
     *
     * @param MatchedUserPairListRequest $request
     * @param AdminDatingService $adminDatingService
     * @return JsonResponse
     *
     * @urlParam id integer required id of dating
     *
     * @response 200 {
     *  "message": "Successful",
     *  "data": []
     * }
     * @response 512 {
     *  "message":"Error encountered while updating status."
     *  "data":[]
     * }
     */
    public function getUpdateMatchedPairList($id, AdminDatingService $adminDatingService)
    {
        $response = $adminDatingService->getDatingById($id)->handleApiResponse();

        self::setResponse($response['status'], $response['message'], $response['data']);
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * Update matching date status
     *
     * @param MatchedUserPairListRequest $request
     * @param AdminDatingService $adminDatingService
     * @return JsonResponse
     *
     * @urlParam id integer required id of dating
     * @bodyParam male integer required id of male user
     * @bodyParam female integer required id of female user
     * @bodyParam area integer required id of area user
     * @bodyParam cafe integer required id of cafe user
     * @bodyParam date integer required id of matching_date user
     * @bodyParam time time required time to date
     *
     * @response 200 {
     *  "message": "Successful",
     *  "data": []
     * }
     * @response 512 {
     *  "message":"Error encountered while updating status."
     *  "data":[]
     * }
     */
    public function updateMatchedPairList(MatchedUserPairListRequest $request, $id, AdminDatingService $adminDatingService)
    {
        $response = $adminDatingService->updateDating($request->all(), $id)->handleApiResponse();

        self::setResponse($response['status'], $response['message'], $response['data']);
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * Update matching date status
     *
     * @param CancelDatingRequest $request
     * @param AdminDatingService $adminDatingService
     * @return JsonResponse
     *
     * @urlParam id integer required id of dating
     *
     * @response 200 {
     *  "message": "Successful",
     *  "data": []
     * }
     * @response 512 {
     *  "message":"Error encountered while updating status."
     *  "data":[]
     * }
     */
    public function cancelMatchedPairList($id, CancelDatingRequest $request, AdminDatingService $adminDatingService)
    {
        $response = $adminDatingService->cancelDatingByAdmin($id, $request->userId)->handleApiResponse();

        self::setResponse($response['status'], $response['message'], $response['data']);
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

}
