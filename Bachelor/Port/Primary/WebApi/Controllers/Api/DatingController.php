<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Api;

use App\Http\Requests\CancelDatingRequest;
use App\Http\Requests\CancelledByPartnerRequest;
use Bachelor\Application\User\Services\DatingApplicationService;
use Bachelor\Application\User\Services\Interfaces\DatingApplicationServiceInterface;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * @group Dating
 */
class DatingController extends BaseController
{
    /**
     * get Match Profile
     *
     * @param DatingApplicationServiceInterface $datingService
     * @return JsonResponse
     *
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": []
     * }
     */
    public function getMatchProfile(DatingApplicationServiceInterface $datingService)
    {
        DB::beginTransaction();
        try {
            $response = $datingService->getMatchProfile();

            $this->setResponse($response['status'], $response['message'], $response['data']);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();

            throw $exception;
        }
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * get Match Profile Detail
     *
     * @param DatingApplicationServiceInterface $datingService
     * @return JsonResponse
     *
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": []
     * }
     */
    public function getMatchProfileDetail(DatingApplicationServiceInterface $datingService,int $datingId)
    {
        DB::beginTransaction();
        try {
            $response = $datingService->getMatchProfileDetail($datingId);

            $this->setResponse($response['status'], $response['message'], $response['data']);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();

            throw $exception;
        }
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }


    /**
     * Cancel date
     *
     * @param CancelDatingRequest $request
     * @param DatingApplicationServiceInterface $datingService
     * @return JsonResponse
     *
     * @bodyParam cancel0ption integer[] nullable Type of cancellation
     * @bodyParam reasonForCancellation tinyint[] required reason_for_cancellation
     * @bodyParam reasonForCancellationOtherText string[191] nullable reason_for_cancellation_other_text
     * @bodyParam reasonForCancellationDissatisfactionOtherText string[191] nullable reason_for_cancellation_dissatisfaction_other_text
     * @bodyParam detailedReason string[191] required detailed_reason_for_cencellation
     * @bodyParam datingId string[] required ID of Dating request to participate
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": []
     * }
     * @response 512 {
     *   "message": {
     *       "reason_for_cancellation": [
     *           "The selected cancel option is invalid."
     *       ]
     *   },
     *   "data": []
     * }
     */
    public function cancelDating(CancelDatingRequest $request, DatingApplicationServiceInterface $datingService)
    {
        DB::beginTransaction();
        try {
            $response = $datingService->cancelDating($request->all());

            $this->setResponse($response['status'], $response['message'], $response['data']);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();

            throw $exception;
        }
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * Cancelled By Partner
     *
     * @param CancelledByPartnerRequest $request
     * @param DatingApplicationServiceInterface $datingService
     * @return JsonResponse
     *
     * @bodyParam datingId string required ID of Dating request to participate
     * @bodyParam request_rematching bool required request rematching or not
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": []
     * }
     * @response 512 {
     *   "message": {
     *       "requestRematching": [
     *           "requestRematching is required."
     *       ]
     *   },
     *   "data": []
     * }
     */
    public function cancelledByPartner(CancelledByPartnerRequest $request, DatingApplicationServiceInterface $datingService)
    {
        DB::beginTransaction();
        try {
            $response = $datingService->cancelledByPartner($request->all());

            $this->setResponse($response['status'], $response['message'], $response['data']);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();
            throw $exception;
        }
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }
}
