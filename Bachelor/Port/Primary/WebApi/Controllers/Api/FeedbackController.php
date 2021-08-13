<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Api;

use App\Http\Requests\CreateFeedbackRequest;
use Bachelor\Application\User\Services\FeedbackService;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Bachelor\Utility\Helpers\Utility;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class FeedbackController extends BaseController
{
    /**
     * @param CreateFeedbackRequest $request
     * @param FeedbackService $feedBackService
     * @return JsonResponse
     * @throws \Exception
     *
     * @response 200 {
     *    "message": "Successfully created new user review",
     *    "data": []
     * }
     * @response 512 {
     *    "message": "Dating has existed for feedback.",
     *    "data": []
     *  }
     */
    public function store(CreateFeedbackRequest $request, FeedbackService $feedBackService): JsonResponse
    {
        DB::beginTransaction();
        try {
            $user = Auth::user()->getDomainEntity();
            $params = $request->all();
            $datingIdDecoded = Utility::decode($params['dating_id']);
            $response = $feedBackService->isNeedGiveFeedbackBy($user, (int)$datingIdDecoded)->handleApiResponse();
            if ($response['data']['canGiveFeedback']) {
                $responseFeedback = $feedBackService->storeProcess($user->getId(), $params);

                self::setResponse($responseFeedback['status'], $responseFeedback['message'], $responseFeedback['data']);
            } else {
                $this->message = $response['message'];
                return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
            }
            DB::commit();
        } catch (Throwable $exception) {

            DB::rollback();
            throw $exception;
        }

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * Check user need to send feedback
     *
     * @param FeedbackService $feedBackService
     * @return JsonResponse
     *
     * @response 200 {
     *   "message": "Successful",
     *   "data": {
     *      "canGiveFeedback": false
     *   }
     * }
     *
     */
    public function isNeedGiveFeedback(FeedbackService $feedBackService): JsonResponse
    {
        $user = Auth::user()->getDomainEntity();
        $response = $feedBackService->isNeedGiveFeedbackBy($user)->handleApiResponse();

        return ApiResponseHandler::jsonResponse($response['status'], $response['message'], $response['data']);
    }

    /**
     * @param FeedbackService $feedbackService
     * @param string $datingIdEncoded
     * @return JsonResponse
     *
     * @response 200 {
     *   "message": "Successful",
     *   "data": {
     *      "review_data": []
     *      "dating_need_feedback": []
     *   }
     * }
     */
    public function getInfoGenerateFeedback(FeedbackService $feedbackService, Request $request): JsonResponse
    {
        $user = Auth::user()->getDomainEntity();
        $data = $feedbackService->getInfoGenerateFeedback($user, $request->get('dating_id_encoded'));

        return ApiResponseHandler::jsonResponse(Response::HTTP_OK, __('api_messages.successful'), $data);
    }

    /**
     * @param FeedbackService $feedbackService
     * @return JsonResponse
     *
     * @response 200 {
     *   "message": "Successful",
     *   "data": {
     *      "review_data": []
     *      "dating_need_feedback": []
     *   }
     * }
     */
    public function checkSendFeedback(FeedbackService $feedbackService): JsonResponse
    {
        $user = Auth::user()->getDomainEntity();
        $data = $feedbackService->getSendFeedbackCondition($user);

        return ApiResponseHandler::jsonResponse(Response::HTTP_OK, __('api_messages.successful'), $data);
    }
}
