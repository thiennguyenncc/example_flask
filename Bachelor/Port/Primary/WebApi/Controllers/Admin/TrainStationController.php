<?php


namespace Bachelor\Port\Primary\WebApi\Controllers\Admin;


use App\Http\Requests\TrainStationRequest;
use Bachelor\Application\Admin\Services\AdminTrainStationService;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Illuminate\Http\JsonResponse;

class TrainStationController extends BaseController
{
    /**
     * Get train stations
     *
     * @url admin/train-stations
     * @method GET
     * @param AdminTrainStationService $trainStationService
     * @return JsonResponse
     */
    public function getTrainStations(TrainStationRequest $request, AdminTrainStationService $trainStationService)
    {
        // Retrieve all train stations
        $response = $trainStationService->getTrainStation($request->all())->handleApiResponse();

        // Set api response
        $this->setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }
}
