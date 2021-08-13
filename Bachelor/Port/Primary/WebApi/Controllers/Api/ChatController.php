<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Api;

use Bachelor\Application\User\Services\ChatService;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends BaseController
{
    /**
     * @var ChatService
     */
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    /**
     * @return JsonResponse
     */
    public function getToken(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user()->getDomainEntity();
        $identity = $user->getId();
        $response = $this->chatService->getToken($identity);

        return ApiResponseHandler::jsonResponse($response['code'], $response['message'], $response['data']);
    }

    public function sentMessage(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user()->getDomainEntity();
        $roomId = $request->get('room_id');
        $this->chatService->sentMessage($user, $roomId);

        return ApiResponseHandler::jsonResponse(200, 'Successful', []);
    }

    public function getMessage(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user()->getDomainEntity();
        $roomId = $request->get('room_id');
        $direction = $request->get('direction') === 'newer' ? 'newer' : 'older';
        $messageId = $request->get('message_id');
        $limit = intval($request->get('limit')) <= 100 ? $request->get('limit') : 20;
        $messages = $this->chatService->getMessage($user->getId(), $roomId, $direction, $messageId, $limit);

        return ApiResponseHandler::jsonResponse(200, 'Successful', $messages);
    }

    /**
     *  Funtion get data for partner detail
     */
    public function getData(Request $request)
    {
        $userId = $request->get('user_id');
        $partnerId = $request->get('partner_id');
        $roomId = $request->get('room_id');
        $datingId = $request->get('dating_id');
        $data['unread_number'] = $this->chatService->unreadMessagesNumber($userId, $roomId);
        $data['room_id'] = $this->chatService->getRoomByUserId($userId, $partnerId);
        $data['displayChat'] = $this->chatService->displayChat($datingId);
        $data['can_cancel_date'] = $data['displayChat'];

        return ApiResponseHandler::jsonResponse(200, 'Successful', $data);
    }

    /**
     * get Dating day able to chat
     *
     * @param Request $request
     * @param ChatService $datingService
     * @return JsonResponse
     *
     * @bodyParam dayOfWeek string dating day of week
     *
     * @response 200 {
     *    "message": "Successful",
     *    "data": []
     * }
     * @response 512 {
     *   "message": {},
     *   "data": []
     * }
     */
    public function getDatingDayAbleToChat(Request $request, ChatService $datingService)
    {
        DB::beginTransaction();
        try {
            $user = Auth::user()->getDomainEntity();
            $datingDay = ucwords($request->get('dayOfWeek'));
            $response = $datingService->getDatingDayAbleToChat($user, $datingDay);
            $this->setResponse($response['status'], $response['message'], $response['data']);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            throw $exception;
        }
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    public function getChatByRoomCode(Request $request)
    {
        try {
            $response = $this->chatService->getChatByRoomCode($request->id);
            $this->setResponse($response['status'], $response['message'], $response['data']);
        } catch (\Exception $exception) {
            throw $exception;
        }
        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }
}
