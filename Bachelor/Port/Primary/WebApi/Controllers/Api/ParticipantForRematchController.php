<?php
namespace Bachelor\Port\Primary\WebApi\Controllers\Api;

use App\Http\Requests\CancelParticipateRequest;
use App\Http\Requests\CancelRematchRequest;
use App\Http\Requests\ParticipateRematchRequest;
use Bachelor\Application\User\Services\ParticipantForRematchService;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 *
 * @group ParticipantForRematchController
 */
class ParticipantForRematchController extends BaseController
{

    /**
     * Cancel participation for rematching
     *
     * @param CancelRematchRequest $request
     * @param ParticipantForRematchService $participantForRematchService
     * @return JsonResponse
     */
    public function cancelParticipateRematching(CancelRematchRequest $request, ParticipantForRematchService $participantForRematchService): JsonResponse
    {
        $response = $participantForRematchService->requestToCancel($request->datingDayIds)->handleApiResponse();

        $this->setResponse($response['status'], $response['message'], $response['data']);
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * @param ParticipateRematchRequest $request
     * @param ParticipantForRematchService $participantForRematchService
     * @return JsonResponse
     */

    public function requestParticipateRematching(ParticipateRematchRequest $request, ParticipantForRematchService $participantForRematchService): JsonResponse
    {
        $response = $participantForRematchService->participateAfterDatingCancelled(Auth::user()->getDomainEntity(), $request->datingId)
            ->handleApiResponse();

        $this->setResponse($response['status'], $response['message'], $response['data']);
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }
}
