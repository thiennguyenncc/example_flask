<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Api;

use App\Http\Requests\ApplyBachelorCouponRequest;
use App\Http\Requests\CancelParticipateRequest;
use App\Http\Requests\CancelSampleParticipateRequest;
use App\Http\Requests\ParticipateRequest;
use App\Http\Requests\RetrieveMatchingDatesRequest;
use Bachelor\Application\User\Services\Interfaces\ParticipantMainMatchServiceInterface;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @group Participants
 */
class ParticipantMainMatchController extends BaseController
{
    /**
     * Get open dates for weeks
     *
     * @param RetrieveMatchingDatesRequest $request
     * @param ParticipantMainMatchServiceInterface $participantService
     * @return JsonResponse
     *
     * @response 200 *{
     *    "message": "Successful",
     *    "data": {
     *        "user": 1,
     *        "participation_availability": "none",
     *        "subscription": "trial",
     *        "need_send_feedback": false,
     *        "weeks": [
     *            [
     *                {
     *                    "id": 4,
     *                    "dating_day": "tuesday",
     *                    "dating_date": "2020-12-22",
     *                    "dating_day_label": "Tuesday",
     *                    "is_participated": true,
     *                    "available_after": 1613952000,
     *                    "recommendation": false,
     *                    "awaiting_cancel": true,
     *                    "can_participate": false
     *                }
     *            ], [
     *                {
     *                    "id": 2,
     *                    "dating_day": "thursday",
     *                    "dating_date": "2020-12-31",
     *                    "dating_day_label": "Thursday",
     *                    "is_participated": false,
     *                    "available_after": 1613952000,
     *                    "recommendation": true,
     *                    "awaiting_cancel": false,
     *                    "can_participate": true
     *                }
     *            ], [
     *                {
     *                    "id": 1,
     *                    "dating_day": "saturday",
     *                    "dating_date": "2021-01-09",
     *                    "dating_day_label": "Saturday",
     *                    "is_participated": false,
     *                    "available_after": 1613952000,
     *                    "recommendation": false,
     *                    "awaiting_cancel": false,
     *                    "can_participate": true
     *                }
     *            ]
     *        ]
     *    }
     * }
     * @response 512 {
     *      "message":"Error Encountered while getting open dates",
     *      "data":[]
     *  }
     */
    public function getDatingDays(RetrieveMatchingDatesRequest $request, ParticipantMainMatchServiceInterface $participantService): JsonResponse
    {
        $response = $participantService->getDatingDays(Auth::user()->getDomainEntity())->handleApiResponse();

        self::setResponse($response['status'], $response['message'], $response['data']);
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * Get already registered dates for user
     *
     * @param RetrieveMatchingDatesRequest $request
     * @param ParticipantMainMatchServiceInterface $participantService
     * @return JsonResponse
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": [
     *        {
     *            "id": 2,
     *            "dating_day": "tuesday",
     *            "dating_date": "2020-12-22",
     *            "status": 0
     *        }, {
     *            "id": 3,
     *            "dating_day": "saturday",
     *            "dating_date": "2020-12-26",
     *            "status": 0
     *        }
     *    ]
     * }
     * @response 512 {
     *      "message":"Error Encountered while getting registered dates",
     *      "data":[]
     *  }
     */
    public function getAwaitingParticipantDatingDays(RetrieveMatchingDatesRequest $request, ParticipantMainMatchServiceInterface $participantService): JsonResponse
    {
        $response = $participantService->getAwaitingParticipantDatingDays(Auth::user()->getDomainEntity())->handleApiResponse();

        self::setResponse($response['status'], $response['message'], $response['data']);
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * Get dates recommendation info for user
     * TODO: move to awaiting cancel / recommendation controller
     *
     * @param RetrieveMatchingDatesRequest $request
     * @param ParticipantMainMatchServiceInterface $participantService
     * @return JsonResponse
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": [
     *        {
     *            "id": 2,
     *            "dating_day": "thursday",
     *            "dating_date": "2020-12-17",
     *            "recommendation": "",
     *            "awaiting_cancel": "awaiting_cancel"
     *        }, {
     *            "id": 1,
     *            "dating_day": "saturday",
     *            "dating_date": "2020-12-19",
     *            "recommendation": "recommend",
     *            "awaiting_cancel": ""
     *        }
     *    ]
     * }
     * @response 512 {
     *      "message":"Error Encountered while getting date status",
     *      "data":[]
     *  }
     */
    public function getMatchingDatesStatus(RetrieveMatchingDatesRequest $request, ParticipantMainMatchServiceInterface $participantService): JsonResponse
    {
        $response = $participantService->getDatesStatus(Auth::user()->getDomainEntity())->handleApiResponse();

        self::setResponse($response['status'], $response['message'], $response['data']);
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * Request to participate
     *
     * @param ParticipateRequest $request
     * @param ParticipantMainMatchServiceInterface $participantService
     * @return JsonResponse
     *
     * @bodyParam dateIds array required Contain dateIds and couponIds necessary for each date
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": []
     * }
     * @response 512 {
     *    "message": "You are already participated!",
     *    "data": []
     * }
     * @throws Throwable
     */
    public function requestParticipateMainMatch(ParticipateRequest $request, ParticipantMainMatchServiceInterface $participantService): JsonResponse
    {
        DB::beginTransaction();
        try {
            if (!empty($request->get('cancelDateIds'))) {
                $participantService->requestToCancel(Auth::user()->getDomainEntity(), $request->get('cancelDateIds'));
            }

            $response = $participantService->requestToParticipate(
                Auth::user()->getDomainEntity(),
                $request->get('requestDateIds')
            )->handleApiResponse();

            DB::commit();
            self::setResponse($response['status'], $response['message'], $response['data']);
        } catch (Exception $exception) {

            DB::rollback();
            throw $exception;
        }
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * Cancel participate
     *
     * @param CancelParticipateRequest $request
     * @param ParticipantMainMatchServiceInterface $participantService
     * @return JsonResponse
     *
     * @bodyParam dateIds integer[] required IDs of Dates request to participate
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": []
     * }
     * @response 512 {
     *    "message": "You cannot cancel multiple dates at the same time",
     *    "data": []
     * }
     */
    public function cancelParticipateMainMatch(CancelParticipateRequest $request, ParticipantMainMatchServiceInterface $participantService): JsonResponse
    {
        DB::beginTransaction();
        try {
            $response = $participantService->requestToCancel(Auth::user()->getDomainEntity(), $request->get('dateIds'))->handleApiResponse();

            DB::commit();
            self::setResponse($response['status'], $response['message'], $response['data']);
        } catch (Exception $exception) {

            DB::rollback();
            throw $exception;
        }
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * Cancel sample participate
     *
     * @param ParticipantMainMatchServiceInterface $participantService
     * @param CancelSampleParticipateRequest $request
     * @return JsonResponse
     *
     * @throws Throwable
     * @response 200 {
     *    "message": "Successful",
     *    "data": []
     * }
     * @response 512 {
     *    "message": "You cannot cancel multiple dates at the same time",
     *    "data": []
     * }
     */
    public function cancelSampleParticipateMainMatch(
        ParticipantMainMatchServiceInterface $participantService,
        CancelSampleParticipateRequest $request
    ): JsonResponse
    {
        DB::beginTransaction();
        try {
            $response = $participantService->requestToCancelSampleDates(
                Auth::user()->getDomainEntity(),
                $request->get('datingDayIds')
            )->handleApiResponse();

            DB::commit();
            self::setResponse($response['status'], $response['message'], $response['data']);
        } catch (Exception $exception) {

            DB::rollback();
            throw $exception;
        }
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }
}
