<?php

namespace Bachelor\Application\Admin\Services;

use Bachelor\Application\Admin\Services\Interfaces\AdminChatServiceInterface;
use Bachelor\Domain\Communication\Chat\Services\ChatService;
use Illuminate\Http\Response;

class AdminChatService implements AdminChatServiceInterface
{
    /**
     * @var ChatService
     */
    private $chatInterface;

    /**
     * @var int
     */
    private $status;

    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $data = [];

    /**
     * AdminChatService constructor.
     * @param ChatService $chatInterface
     */
    public function __construct(ChatService $chatInterface)
    {
        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
        $this->chatInterface = $chatInterface;
    }

    /**
     * Get room list
     *
     * @param array $filter
     * @return AdminChatServiceInterface
     */
    public function getRooms(array $filter): AdminChatServiceInterface
    {
        $this->data = $this->chatInterface->getRooms($filter)->toArray();
        return $this;
    }

    /**
     * Get room detail
     *
     * @param int $id
     * @return AdminChatServiceInterface
     */
    public function getRoomDetail($id): AdminChatServiceInterface
    {
        $this->data = $this->chatInterface->getRoomDetail($id)->toArray();
        return $this;
    }

    /**
     * Get message list
     *
     * @param array $filter
     * @return AdminChatServiceInterface
     */
    public function getMessage(array $filter): AdminChatServiceInterface
    {
        $this->chatInterface->getMessages($filter);
    }

    /**
     * Format response data
     *
     * @return array
     */
    public function handleApiResponse(): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data
        ];
    }
}
