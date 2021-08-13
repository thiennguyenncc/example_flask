<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Admin;

use Bachelor\Application\Admin\Services\Interfaces\AdminChatServiceInterface;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Coupon
 */
class ChatController extends BaseController
{
    /**
     * get rooms list or room detail by filter key
     *
     * @param Request $request
     * @param AdminChatServiceInterface $chatService
     * @return JsonResponse
     *
     * @url /admin/chat/rooms
     * @urlParam search string or int nullable key for filter room list Example: room id, user name, user id
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": []
     * }
     * @response 512 {
     *     "message":"Error encountered while get rooms information."
     *     "data":[]
     * }
     */
    public function getRooms(Request $request, AdminChatServiceInterface $chatService)
    {
        $response = $chatService->getRooms($request->all())->handleApiResponse();

        self::setResponse($response['status'], $response['message'], $response['data']);
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }
    /**
     * get rooms detail by room id
     *
     * @param int $id
     * @param AdminChatServiceInterface $chatService
     * @return JsonResponse
     *
     * @url /admin/chat/room/{id}
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": []
     * }
     * @response 512 {
     *     "message":"Error encountered while get rooms information."
     *     "data":[]
     * }
     */
    public function getRoomDetail($id, AdminChatServiceInterface $chatService)
    {
        $response = $chatService->getRoomDetail($id)->handleApiResponse();

        self::setResponse($response['status'], $response['message'], $response['data']);
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * get list messages
     *
     * @param Request $request
     * @param AdminChatServiceInterface $chatService
     * @return JsonResponse
     *
     * @url /admin/chat/messages
     * @urlParam search string nullable character for filter message list Example: message content
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": []
     * }
     * @response 512 {
     *     "message":"Error encountered while get messages information."
     *     "data":[]
     * }
     */
    public function getMessages(Request $request, AdminChatServiceInterface $chatService)
    {
        $response = $chatService->getRooms($request->all())->handleApiResponse();

        self::setResponse($response['status'], $response['message'], $response['data']);
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }
}
