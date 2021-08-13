<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Admin;

use App\Http\Requests\AreaRequest;
use App\Http\Requests\CreateAreaRequest;
use App\Http\Requests\DeleteAreaRequest;
use App\Http\Requests\UpdateAreaRequest;
use Bachelor\Application\User\Services\PrefectureService;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Class AreaController
 * @package Bachelor\Port\Primary\WebApi\Controllers\Admin
 *
 * @group Areas
 */
class AreaController extends BaseController
{
    /**
     *  Get all the areas
     *
     * @param AreaRequest $request
     * @param PrefectureService $prefectureService
     * @return JsonResponse
     *
     * @url admin/areas
     * @queryParam name string Name of area
     * @queryParam prefecture_id integer Prefecture id
     * @queryParam status integer Status
     * @queryParam page string Represent the page number in pagination
     * @response 200 {
     *      "message" : "Successfully",
     *      "data" : [
     *          "message" : "Area retrieved successfully",
     *          "areas" : []
     *      ]
     *  }
     * @response 512 {
     *      "message":"Error Encountered while retrieving area data in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/SmsController.php at 43 due to `Exception message`",
     *      "data":[]
     *  }
     */
    public function handle(AreaRequest $request, PrefectureService $prefectureService): JsonResponse
    {
        // Retrieve area data
        $response =  $prefectureService->getAreaData($request->all())
            ->handleApiResponse();

        // set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }

    /**
     * Create new area
     *
     * @param CreateAreaRequest $request
     * @param PrefectureService $prefectureService
     * @return JsonResponse
     *
     * @url admin/areas/create
     * @bodyParam nameEn string required Represent the name in English. Example: xyz
     * @bodyParam nameJa string required Represent the name in Japanese. Example: abc
     * @bodyParam adminId integer required Represent the admin Id. Example: 1
     * @bodyParam prefectureId integer required Represent the prefecture Id. Example: 1
     * @response 200 {
     *      "message" : "Successfully",
     *      "data" : [
     *          "message" : "Area created successfully",
     *          "area" : []
     *      ]
     *  }
     * @response 512 {
     *      "message":"Error Encountered while creating area in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/SmsController.php at 43 due to `Exception message`",
     *      "data":[]
     *  }
     */
    public function create(CreateAreaRequest $request, PrefectureService $prefectureService): JsonResponse
    {
        // Retrieve area data
        $response =  $prefectureService->createNewArea($request->all())
            ->handleApiResponse();

        // set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }

    /**
     * Update the given area
     *
     * @param UpdateAreaRequest $request
     * @param PrefectureService $prefectureService
     * @param int $areaId
     * @return JsonResponse
     *
     * @url admin/areas/update/{id}
     * @urlParam id integer required The Id of the Area
     * @bodyParam nameEn string required Represent the name in English. Example: xyz
     * @bodyParam nameJa string required Represent the name in Japanese. Example: abc
     * @bodyParam adminId integer required Represent the admin Id. Example: 1
     * @bodyParam prefectureId integer required Represent the prefecture Id. Example: 1
     * @response 200 {
     *      "message" : "Successfully",
     *      "data" : [
     *          "message" : "Area updated successfully",
     *          "area" : []
     *      ]
     *  }
     * @response 512 {
     *      "message":"Error Encountered while updating area data in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/SmsController.php at 43 due to `Exception message`",
     *      "data":[]
     *  }
     */
    public function update(UpdateAreaRequest $request, PrefectureService $prefectureService, int $areaId): JsonResponse
    {
        // Retrieve area data
        $response =  $prefectureService->updateArea($areaId, $request->all())
            ->handleApiResponse();

        // set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }

    /**
     * Delete the given area
     *
     * @param DeleteAreaRequest $request
     * @param PrefectureService $prefectureService
     * @param int $prefectureId
     * @return JsonResponse
     *
     * @url admin/areas/delete/{id}
     * @urlParam id integer required The Id of the Area
     * @response 200 {
     *      "message" : "Successfully",
     *      "data" : [
     *          "message" : "Area deleted successfully",
     *          "areas" : []
     *      ]
     *  }
     * @response 512 {
     *      "message":"Error Encountered while deleting area in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/SmsController.php at 43 due to `Exception message`",
     *      "data":[]
     *  }
     */
    public function delete(DeleteAreaRequest $request, PrefectureService $prefectureService, int $prefectureId): JsonResponse
    {
        // Retrieve area data
        $response =  $prefectureService->analyzeAndDeleteArea($prefectureId, $request->all())
            ->handleApiResponse();

        // set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }
}
