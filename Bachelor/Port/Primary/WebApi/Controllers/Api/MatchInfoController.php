<?php


namespace Bachelor\Port\Primary\WebApi\Controllers\Api;


use Bachelor\Application\User\Services\UserMatchInfoService;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MatchInfoController extends BaseController
{
    /**
     * MatchInfoController constructor.
     */
    public function __construct()
    {
        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
        $this->data = [];
    }

    /**
     * get Match Profile
     *
     * @param  $matchInfoService
     *
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": []
     * }
     */
    public function filterGroupByAgeAndGender(Request $request, UserMatchInfoService $matchInfoService)
    {
        $response = $matchInfoService->filterGroupByAgeAndGender($request['age'], $request['gender'])->handleApiResponse();;

        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }
}
