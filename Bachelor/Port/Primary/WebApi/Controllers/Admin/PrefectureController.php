<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Admin;

use App\Http\Requests\CreatePrefectureRequest;
use App\Http\Requests\DeletePrefectureRequest;
use App\Http\Requests\PrefectureRequest;
use App\Http\Requests\UpdatePrefectureRequest;
use Bachelor\Application\User\Services\PrefectureService;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Class PrefectureController
 * @package Bachelor\Port\Primary\WebApi\Controllers\Admin
 *
 * @group Prefecture
 */
class PrefectureController extends BaseController
{
    /**
     *  Get all the prefectures
     *
     * @param PrefectureRequest $request
     * @param PrefectureService $prefectureService
     * @return JsonResponse
     *
     * @url /admin/prefectures
     * @urlParam search string nullable Represent the search string. Example: xyz
     * @urlParam filter array nullable Represent the filter param. Example: [ "status" : 1 ]
     * @urlParam page integer nullable Represent the page number in pagination. Example: 2
     * @response 200 {
     *      "message" : "Successfully",
     *      "data" : [
     *          "message" : "Prefecture retrieved successfully",
     *          "prefectures" : []
     *      ]
     *  }
     * @response 512 {
     *      "message":"Error Encountered while retrieving prefecture data data in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/SmsController.php at 43 due to `Exception message`",
     *      "data":[]
     *  }
     */
    public function handle(PrefectureRequest $request, PrefectureService $prefectureService): JsonResponse
    {
        // Retrieve prefecture data
        $response =  $prefectureService->getPrefectureData($request->all())
            ->handleApiResponse();

        // set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }

    /**
     * Create new prefecture
     *
     * @param CreatePrefectureRequest $request
     * @param PrefectureService $prefectureService
     * @return JsonResponse
     *
     * @url admin/prefectures/create
     * @bodyParam nameEn string required Represent the name in English. Example: xyz
     * @bodyParam nameJa string required Represent the name in Japanese. Example: abc
     * @bodyParam adminId integer required Represent the admin Id. Example: 1
     * @bodyParam countryId integer required Represent the country Id. Example: 1
     * @response 200 {
     *      "message" : "Successfully",
     *      "data" : [
     *          "message" : "Prefecture created successfully",
     *          "prefecture" : []
     *      ]
     *  }
     * @response 512 {
     *      "message":"Error Encountered while creating the prefecture : '.request('id').' in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/SmsController.php at 43 due to `Exception message`",
     *      "data":[]
     *  }
     */
    public function create(CreatePrefectureRequest $request, PrefectureService $prefectureService): JsonResponse
    {
        // Retrieve prefecture data
        $response =  $prefectureService->createNewPrefecture($request->all())
            ->handleApiResponse();

        // set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }

    /**
     * Update the given prefecture
     *
     * @param UpdatePrefectureRequest $request
     * @param PrefectureService $prefectureService
     * @param int $prefectureId
     * @return JsonResponse
     *
     * @url admin/prefectures/update/{id}
     * @urlParam id integer required Represents the id of the prefecture
     * @bodyParam nameEn string required Represent the name in English. Example: xyz
     * @bodyParam nameJa string required Represent the name in Japanese. Example: abc
     * @bodyParam adminId integer required Represent the admin Id. Example: 1
     * @bodyParam countryId integer required Represent the country Id. Example: 1
     * @response 200 {
     *      "message" : "Successfully",
     *      "data" : [
     *          "message" : "Prefecture updated successfully",
     *          "prefecture" : []
     *      ]
     *  }
     * @response 512 {
     *      "message":"Error Encountered while updating prefecture : '.$prefectureId.' in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/SmsController.php at 43 due to `Exception message`",
     *      "data":[]
     *  }
     */
    public function update(UpdatePrefectureRequest $request, PrefectureService $prefectureService, int $prefectureId): JsonResponse
    {
        // Retrieve prefecture data
        $response =  $prefectureService->updatePrefecture($prefectureId, $request->all())
            ->handleApiResponse();

        // set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }

    /**
     * Delete the given prefecture
     *
     * @param DeletePrefectureRequest $request
     * @param PrefectureService $prefectureService
     * @param int $prefectureId
     * @return JsonResponse
     *
     * @url admin/prefectures/delete/{id}
     * @urlParam id integer required Represents the id of the prefecture
     * @queryParam forceDelete boolean required Depicts if to force delete the prefecture
     * @response 200 {
     *      "message" : "Successfully",
     *      "data" : [
     *          "message" : "Prefecture deleted successfully",
     *      ]
     *  }
     * @response 512 {
     *      "message":"Error Encountered while deleting prefecture : '.$prefectureId.' in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/SmsController.php at 43 due to `Exception message`",
     *      "data":[]
     *  }
     * @response 516 {
     *      "message":"Prefecture already in use",
     *      "data":[]
     *  }
     */
    public function delete(DeletePrefectureRequest $request, PrefectureService $prefectureService, int $prefectureId): JsonResponse
    {
        // Retrieve prefecture data
        $response =  $prefectureService->analyzeAndDeletePrefecture($prefectureId, $request->all())
            ->handleApiResponse();

        // set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }
}
