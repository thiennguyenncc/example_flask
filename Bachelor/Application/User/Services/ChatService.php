<?php

namespace Bachelor\Application\User\Services;

use Bachelor\Application\User\Services\Interfaces\ChatServiceInterface;
use Bachelor\Domain\Communication\Chat\Event\ChatReceived;
use Bachelor\Domain\Communication\Chat\Services\ChatService as ChatDomainService;
use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Domain\DatingManagement\Dating\Enums\DatingUserProperty;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\DatingManagement\Dating\Models\Dating;
use Bachelor\Domain\DatingManagement\DatingDay\Interfaces\DatingDayRepositoryInterface;
use Bachelor\Domain\DatingManagement\DatingDay\Models\DatingDay;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Port\Secondary\Communication\Twilio\Interfaces\TwilioServiceInterface;
use Bachelor\Port\Secondary\Database\Communication\Chat\Interfaces\EloquentRoomInterface;
use Bachelor\Utility\Helpers\Utility;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ChatService
{
    /**
     * Define chat service use in project
     *
     * @var TwilioServiceInterface
     */
    protected $serviceChat;

    /**
     * @var ChatDomainService
     */
    protected $chatDomainService;

    /**
     * @var DatingRepositoryInterface
     */
    protected $datingRepository;

    /**
     * @var DatingDayRepositoryInterface
     */
    protected $datingDayRepository;

    /**
     * @var EloquentRoomInterface
     */
    protected $roomRepository;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var int
     */

    private $status;

    /**
     * @var string
     */
    private $message;

    /*
     * @var array
     */
    private $data = [];

    public function __construct(
        TwilioServiceInterface $twilioService,
        ChatDomainService $chatDomainService,
        DatingRepositoryInterface $datingRepository,
        DatingDayRepositoryInterface $datingDayRepository,
        EloquentRoomInterface $roomRepository,
        UserRepositoryInterface $userRepository,
    )
    {
        $this->serviceChat = $twilioService;
        $this->chatDomainService = $chatDomainService;
        $this->datingRepository = $datingRepository;
        $this->datingDayRepository = $datingDayRepository;
        $this->roomRepository = $roomRepository;
        $this->userRepository = $userRepository;
        $this->status = Response::HTTP_OK;
        $this->message = __('api_messages.successful');
    }

    /**
     * Get token for chat service
     *
     * @param $identity
     * @return array
     */
    public function getToken($identity): array
    {
        return $this->serviceChat->getToken($identity);
    }

    /**
     * Send message chat service
     *
     * @param User $user
     * @param int $roomId
     * @return mixed|void
     */
    public function sentMessage(User $user, string $roomId)
    {
        $roomDao = $this->roomRepository->getDaoBy($roomId);
        $senderId = $user->getId();

        $this->chatDomainService->fetchLatestMessageByRoomId($roomDao);
        $this->chatDomainService->handleReadCursorForRoom($roomDao);

        $receiverId = $roomDao->roomUsers->whereNotIn('user_id', $senderId)->first()->user_id;
        $receiverUser = $this->userRepository->getById($receiverId);

        ChatReceived::dispatch($receiverUser, $roomDao->id);
    }

    /**
     * Get message chat from chat service
     *
     * @param $userId
     * @param $roomId
     * @param $direction
     * @param $messageId
     * @param $limit
     * @return mixed|void
     */
    public function getMessage($userId, $roomId, $direction, $messageId, $limit)
    {
        return $this->chatDomainService->getMessages($userId, $roomId, $direction, $messageId, $limit);
    }

    /**
     * Count unread messages
     *
     * @param $userId
     * @param $roomId
     * @return int
     */
    public function unreadMessagesNumber($userId, $roomId):int
    {
        return $this->chatDomainService->getUnreadMessageNumber($userId, $roomId);
    }

    /**
     * Get room
     *
     * @param $userId
     * @param $partnerId
     * @return mixed|void
     */
    public function getRoomByUserId($userId, $partnerId)
    {
        return $this->chatDomainService->getRoomByUserId($userId, $partnerId);
    }

    /**
     * Check display chat
     *
     * @param $datingId
     * @return bool
     */
    public function displayChat($datingId): bool
    {
        $dating = $this->datingRepository->getDatingById((int)$datingId, DatingStatus::Incompleted);
        if (!$dating) {
            return false;
        }

        return $dating->getDatingDay()->isChatAble();
    }

    /**
     *  Get dating day able to chat
     *
     * @param User $user
     * @param string $dayOfWeek
     * @return DatingDay|array
     */
    public function getDatingDayAbleToChat(User $user, string $dayOfWeek)
    {
        $datingDay = $this->datingDayRepository->getNextDatingDayByDayOfWeek($dayOfWeek);
        if ($datingDay->isChatAble()){
            //get dating
            $dating = $this->datingRepository->getDatingByUserAndDatingDay($user, $datingDay);
            if ($dating->getStatus() == DatingStatus::Incompleted){
                $partnerUser = $dating->getPartnerDatingUserByUser($user)->getUser();
                $chatRoom = $this->chatDomainService->getRoomByUserId($user->getId(), $partnerUser->getId());
                $this->data = $this->chatDataFormat($datingDay, $dating, $chatRoom, $partnerUser->getId());
            }
        }
        return $this->handleApiResponse();
    }

    /**
     * get dating and chat room by room code
     *
     * @param string $roomCode
     *
     * @return array
     */
    public function getChatByRoomCode(string $roomCode)
    {
        $user = Auth::user()->getDomainEntity();
        $userId = $user->getId();
        $roomId = Utility::decode($roomCode);
        $userIdsArr = explode("_", $roomId);
        if (count($userIdsArr) === 2 && in_array($userId, $userIdsArr)) {
            //get dating
            $datingUsers = $this->datingRepository->getLatestDatingUsersByUserIds($userIdsArr, [DatingUserProperty::dating]);
            if (count($datingUsers) > 0) {
                $datingDay = $datingUsers[0]->getDating()->getDatingDay();
                $dating = $datingUsers[0]->getDating();
                $chatRoom = $this->chatDomainService->getRoomByUserId(...$userIdsArr);
                $partnerId = $userId == $userIdsArr[0] ? $userIdsArr[1] : $userIdsArr[0];
                if ($chatRoom['data'] && $dating->getStatus() == DatingStatus::Incompleted) {
                    $this->data = $this->chatDataFormat($datingDay, $dating, $chatRoom, $partnerId);
                }
            }
        }
        return $this->handleApiResponse();
    }

    /**
     * format response chat data
     *
     * @param DatingDay $datingDay
     * @param Dating $dating
     * @param array $chatRoom
     * @param int $partnerId
     *
     * @return array
     */
    public function chatDataFormat(DatingDay $datingDay,Dating $dating, array $chatRoom, int $partnerId)
    {
        return [
            'datetime_text' => Carbon::parse($datingDay->getDatingDate())->format("m/d (D)") . $dating->getStartAt() . '~',
            'chat_id' => $chatRoom['data'],
            'dating_id' => $dating->getId(),
            'partner_id' => $partnerId,
            'dating_day_id' => $datingDay->getId(),
            'day_of_week' => $datingDay->getDatingDayOfWeek(),
            'rematching_time' => $datingDay->getRematchingTime()->toDateTimeString(),
        ];
    }

    /**
     * Format Registration data
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
