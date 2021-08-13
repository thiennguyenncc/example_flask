<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Admin;

use App\Http\Requests\DatingPlaceRequest;
use App\Http\Requests\GetDatingPlaceRequest;
use Bachelor\Application\Admin\Services\AdminDatingPlaceService;
use Bachelor\Application\User\Services\PrefectureService;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Illuminate\Http\JsonResponse;

/**
 * Class DatingPlaceController
 * @package Bachelor\Port\Primary\WebApi\Controllers\Admin
 *
 * @group Dating Places
 */
class DatingPlaceController extends BaseController
{
    /**
     *  Get all the dating place
     *
     * @param GetDatingPlaceRequest $request
     * @param PrefectureService $prefectureService
     * @return JsonResponse
     *
     * @url admin/dating-places
     * @queryParam category string Category
     * @queryParam area_id integer Area id
     * @queryParam status integer Status
     * @queryParam page string Represent the page number in pagination
     * @response 200 {
     *      "message" : "Successfully",
     *      "data" : [
     *          "message" : "Dating Place retrieved successfully",
     *          "areas" : []
     *      ]
     *  }
     * @response 512 {
     *      "message":"Error Encountered while retrieving dating place data in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/SmsController.php at 43 due to `Exception message`",
     *      "data":[]
     *  }
     */
    public function handle(GetDatingPlaceRequest $request, AdminDatingPlaceService $datingPlaceService): JsonResponse
    {
        // Retrieve dating place data
        $response =  $datingPlaceService->getDatingPlaceData($request->all())
            ->handleApiResponse();

        // set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }

    /**
     * Create new dating place
     *
     * @param DatingPlaceRequest $request
     * @param PrefectureService $prefectureService
     * @return JsonResponse
     *
     * @url admin/dating-places/create
     * @urlParam id integer required The Id of the dating place
     * @bodyParam areaId integer required Represents the area to which it belongs string. Example: 1
     * @bodyParam category string required Represents the category of the dating place.Example: cafe
     * @bodyParam latitude number required Represents the latitude of the dating place.Example: 31.123445
     * @bodyParam longitude number required Represents the longitude of the dating place.Example: 123.123123
     * @bodyParam rating number required Represents the rating of the dating place.Example: 5
     * @bodyParam displayPhone string required Represents the displayPhone of the dating place.Example: 073-712-6377
     * @bodyParam phone string required Represents the phone of the dating place.Example: +910737126377
     * @bodyParam nameEn string required Represents the english name of the dating place.Example: xyz
     * @bodyParam nameJa string required Represents the japanese name of the dating place.Example: xyz
     * @bodyParam displayAddress string required Represents the displayAddress of the dating place.Example: xyz, abc, eee
     * @bodyParam zipCode string required Represents the zipCode to which the dating place belongs to.Example: 10000
     * @bodyParam country string required Represents the country to which the dating place belongs to.Example: eee
     * @bodyParam datingPlaceImage file required Represents the datingPlaceImages of the dating place.
     * @response 200 {
     *      "message" : "Successfully",
     *      "data" : [
     *          "message" : "Dating place created successfully",
     *          "areas" : []
     *      ]
     *  }
     * @response 512 {
     *      "message":"Error Encountered while creating dating place in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/SmsController.php at 43 due to `Exception message`",
     *      "data":[]
     *  }
     */
    public function create(DatingPlaceRequest $request, AdminDatingPlaceService $datingPlaceService): JsonResponse
    {
        $response = $datingPlaceService->createNewDatingPlace($request->all())
            ->handleApiResponse();

        // set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }

    /**
     * Update the given dating place
     *
     * @param DatingPlaceRequest $request
     * @param PrefectureService $prefectureService
     * @param int $datingPlaceId
     * @return JsonResponse
     *
     * @url admin/dating-places/update/{id}
     * @urlParam id integer required The Id of the Dating place
     * @bodyParam areaId integer required Represents the area to which it belongs string. Example: 1
     * @bodyParam category string required Represents the category of the dating place.Example: cafe
     * @bodyParam latitude number required Represents the latitude of the dating place.Example: 31.123445
     * @bodyParam longitude number required Represents the longitude of the dating place.Example: 123.123123
     * @bodyParam rating number required Represents the rating of the dating place.Example: 5
     * @bodyParam displayPhone string required Represents the displayPhone of the dating place.Example: 073-712-6377
     * @bodyParam phone string required Represents the phone of the dating place.Example: +910737126377
     * @bodyParam nameEn string required Represents the english name of the dating place.Example: xyz
     * @bodyParam nameJa string required Represents the japanese name of the dating place.Example: xyz
     * @bodyParam displayAddress string required Represents the displayAddress of the dating place.Example: xyz, abc, eee
     * @bodyParam zipCode string required Represents the zipCode to which the dating place belongs to.Example: 10000
     * @bodyParam country string required Represents the country to which the dating place belongs to.Example: eee
     * @bodyParam datingPlaceImage file required Represents the datingPlaceImages of the dating place.
     * @response 200 {
     *      "message" : "Successfully",
     *      "data" : [
     *          "message" : "DatingPlace updated successfully",
     *          "areas" : []
     *      ]
     *  }
     * @response 512 {
     *      "message":"Error Encountered while updating dating place data in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/SmsController.php at 43 due to `Exception message`",
     *      "data":[]
     *  }
     */
    public function update(DatingPlaceRequest $request,  AdminDatingPlaceService $datingPlaceService, int $datingPlaceId): JsonResponse
    {
        // Retrieve dating place data
        $response =  $datingPlaceService->updateDatingPlace($datingPlaceId, $request->all())
            ->handleApiResponse();

        // set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }

    /**
     * Update the given dating place
     *
     * @param PrefectureService $prefectureService
     * @param int $prefectureId
     * @return JsonResponse
     *
     * @url admin/dating-places/delete/{id}
     * @urlParam id integer required The Id of the Dating Place
     * @response 200 {
     *      "message" : "Successfully",
     *      "data" : [
     *          "message" : "Dating Place deleted successfully",
     *          "areas" : []
     *      ]
     *  }
     * @response 512 {
     *      "message":"Error Encountered while deleting dating place in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/SmsController.php at 43 due to `Exception message`",
     *      "data":[]
     *  }
     */
    public function delete(AdminDatingPlaceService $datingPlaceService, int $datingPlaceId): JsonResponse
    {
        // Retrieve dating place data
        $response =  $datingPlaceService->analyzeAndDeleteDatingPlace($datingPlaceId)
            ->handleApiResponse();

        // set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }

    /**
     * Update the given dating place
     *
     * @param PrefectureService $prefectureService
     * @param int $datingPlaceId
     * @return JsonResponse
     *
     * @url admin/dating-places/change-approve/{id}
     */
    public function approveOrDisapproveDatingPlace(AdminDatingPlaceService $datingPlaceService, int $datingPlaceId): JsonResponse
    {
        $response =  $datingPlaceService->approveOrDisapproveDatingPlace($datingPlaceId)
            ->handleApiResponse();

        // set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }
}
