<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Admin;

use App\Http\Requests\AdminParticipantAwaitingCountSettingRequest;
use App\Http\Requests\AdminSaveParticipantAwaitingCountSettingRequest;
use Bachelor\Application\Admin\Services\Interfaces\AdminDatingServiceInterface;
use Bachelor\Application\Admin\Services\Interfaces\ParticipantAwaitingCountSettingServiceInterface;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * @group Dating
 */
class ParticipantAwaitingCountSettingController extends BaseController
{
    /**
     * Get participants count and gender ratio settings
     *
     * @param AdminParticipantAwaitingCountSettingRequest $request
     * @param ParticipantAwaitingCountSettingServiceInterface $settingService
     * @return JsonResponse
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": [
     *    ]
     * }
     * @response 512 {
     *  "message":"Error encountered while getting settings."
     *  "data":[]
     * }
     */
    public function handle(AdminParticipantAwaitingCountSettingRequest $request,
                           ParticipantAwaitingCountSettingServiceInterface $settingService,
                           AdminDatingServiceInterface $datingService
    ): JsonResponse
    {
        $datingDay = $datingService->getDatingByDate($request->get('dating_date'));
        $responseCount = $settingService->countParticipants(
            $request->get('prefecture_id'),
            $datingDay->getId()
        )->handleApiResponse();
        $responseSettings = $settingService->getSettings(
            $request->get('prefecture_id'),
            $datingDay->getId(),
            $request->get('gender')
        )->handleApiResponse();

        self::setResponse($responseSettings['status'], $responseSettings['message'], array_merge(
            $responseCount['data'],
            $responseSettings['data']
        ));
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * @param AdminSaveParticipantAwaitingCountSettingRequest $request
     * @param ParticipantAwaitingCountSettingServiceInterface $adminService
     * @return JsonResponse
     */
    public function update(AdminSaveParticipantAwaitingCountSettingRequest $request,
                           ParticipantAwaitingCountSettingServiceInterface $adminService,
                           AdminDatingServiceInterface $datingService
    ): JsonResponse
    {
        $datingDay = $datingService->getDatingByDate($request->get('dating_date'));
        $response = $adminService->updateSettings(
            $request->get('prefecture_id'),
            $datingDay->getId(),
            $request->get('gender'),
            $request->post('settings')
        )->handleApiResponse();

        self::setResponse($response['status'], $response['message'], $response['data']);
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }
}
