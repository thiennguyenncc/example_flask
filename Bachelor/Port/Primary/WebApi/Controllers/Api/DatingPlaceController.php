<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Api;

use Bachelor\Application\User\Services\DatingPlaceService;
use Bachelor\Domain\MasterDataManagement\DatingPlace\Enums\DatingPlaceCategory;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DatingPlaceController extends BaseController
{
    /**
     * @param Request $request
     * @param DatingPlaceService $datingPlaceService
     * @return JsonResponse
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": array
     * }
     */
    public function getThreeCafesAtSameStation(Request $request, DatingPlaceService $datingPlaceService): JsonResponse
    {
        $datingId = $request->get('dating_id');
        if (! $datingId) {
            return ApiResponseHandler::jsonResponse(422, __('api_messages.fail'), []);
        }
        $datingPlaceData = $datingPlaceService->getThreeCafesAtSameStation($datingId);

        return ApiResponseHandler::jsonResponse(200, __('api_messages.successful'), $datingPlaceData);
    }
}
