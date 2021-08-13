<?php


namespace Bachelor\Domain\Communication\Chat\Services;


use Bachelor\Domain\Communication\Chat\Enums\RoomType;
use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Domain\DatingManagement\Dating\Interfaces\DatingRepositoryInterface;
use Bachelor\Domain\UserManagement\User\Models\User;
use Bachelor\Port\Secondary\Communication\Twilio\Interfaces\TwilioServiceInterface;
use Bachelor\Port\Secondary\Communication\Twilio\Repository\TwilioService;
use Bachelor\Port\Secondary\Database\Communication\Chat\Interfaces\EloquentCursorInterface;
use Bachelor\Port\Secondary\Database\Communication\Chat\Interfaces\EloquentMessageInterface;
use Bachelor\Port\Secondary\Database\Communication\Chat\Interfaces\EloquentRoomInterface;
use Bachelor\Port\Secondary\Database\Communication\Chat\Interfaces\EloquentRoomUserInterface;
use Bachelor\Domain\UserManagement\User\Interfaces\UserRepositoryInterface;
use Bachelor\Port\Secondary\Database\Communication\Chat\ModelDao\Room;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ChatService
{

    /**
     * @var EloquentMessageInterface|mixed
     */
    protected $eloquentMessage;

    /**
     * @var EloquentRoomInterface|mixed
     */
    protected $eloquentRoom;

    /**
     * @var TwilioService|mixed
     */
    private $twilioService;

    /**
     * @var EloquentRoomUserInterface
     */
    protected $eloquentRoomUser;

    /**
     * @var $eloquentCursor
     */
    protected $eloquentCursor;

    /**
     * @var $eloquentUser
     */
    protected $eloquentUser;

    /**
     * @var DatingRepositoryInterface
     */
    protected $datingRepository;

    /**
     * Limit messages from twilio service
     */
    const MESSAGE_LIMIT = 100;

    /**
     * ChatService constructor.
     * @param EloquentMessageInterface $eloquentMessage
     * @param EloquentRoomInterface $eloquentRoom
     * @param TwilioServiceInterface $twilioService
     * @param EloquentRoomUserInterface $eloquentRoomUser
     * @param EloquentCursorInterface $eloquentCursor
     * @param UserRepositoryInterface $eloquentUser
     * @param DatingRepositoryInterface $datingRepository
     */
    public function __construct(EloquentMessageInterface $eloquentMessage, EloquentRoomInterface $eloquentRoom, TwilioServiceInterface $twilioService,
                                EloquentRoomUserInterface $eloquentRoomUser, EloquentCursorInterface $eloquentCursor, UserRepositoryInterface $eloquentUser,
                                DatingRepositoryInterface $datingRepository)
    {
        $this->eloquentMessage = $eloquentMessage;
        $this->eloquentRoom = $eloquentRoom;
        $this->twilioService = $twilioService;
        $this->eloquentRoomUser = $eloquentRoomUser;
        $this->eloquentCursor = $eloquentCursor;
        $this->eloquentUser = $eloquentUser;
        $this->datingRepository = $datingRepository;
    }

    /**
     * @param $roomId
     * @return mixed|void
     */
    public function fetchLatestMessageByRoomId(Room $room)
    {
        $roomId = $room->id;
        $message = $this->eloquentMessage->getModel()->where('room_id', $roomId)->orderBy('id', 'DESC')->first();
        $messageId = data_get($message, 'id', null);

        if (!empty($room)) {
            $type = data_get($room, 'type', RoomType::Twilio);
            if ($type == RoomType::Twilio) {
                $messages = $this->getTwilioMessageByRoomId($roomId, $messageId);
                $this->createMessageFromTwilio($messages, $roomId);
            }
        }
    }

    /**
     * Get messages of room id from twilio service
     *
     * @param $roomId
     * @param $messageId
     * @return mixed
     */
    public function getTwilioMessageByRoomId($roomId, $messageId)
    {
        $query = [
            'room_id' => $roomId,
            'limit' => self::MESSAGE_LIMIT
        ];
        if (!empty($messageId)) {
            $query['initial_id'] = $messageId;
            $query['direction'] = 'newer';
        }
        $data = $this->twilioService->getRoomMessages($query);

        return $data['body'];
    }

    /**
     * Save message to database from twilio service
     *
     * @param null $messages
     * @param null $roomId
     */
    public function createMessageFromTwilio($messages = null, $roomId = null)
    {
        foreach ($messages as $message) {
            $item = [
                'room_id' => $roomId,
                'user_id' => $message->from,
                'content' => $message->body,
                'type' => RoomType::Twilio,
                'sid' => (string)$message->sid,
                'index' => (int)$message->index,
                'created_at' => $message->dateCreated,
                'updated_at' => $message->dateUpdated
            ];
            $this->eloquentMessage->updateOrCreate(
                [
                    'sid' => $message->sid
                ],
                $item
            )->save();
        }
    }

    /**
     * @param $roomId
     * @return mixed|void
     */
    public function handleReadCursorForRoom(Room $room)
    {
        $type = data_get($room, 'type', RoomType::Twilio);
        if ($type != RoomType::Twilio) {
            return;
        }

        $roomUsers = $room->roomUsers;
        $roomId = $room->id;

        if (count($roomUsers)) {
            foreach ($roomUsers as $roomUser) {
                $userId = $roomUser->user_id;
                
                $data = $this->twilioService->getMember($roomId, $userId);
                $cursor = data_get($data, 'body');

                if (!empty($cursor)) {
                    $this->eloquentCursor->updateOrCreate([
                        'room_id' => $roomId,
                        'user_id' => $userId,
                    ], [
                        'room_id' => $roomId,
                        'user_id' => $userId,
                        'type' => RoomType::Twilio,
                        'message_id' => 0,
                        'message_index' => $cursor->lastConsumedMessageIndex
                    ]);
                }
            }
        }
    }

    /**
     * Get message from system
     *
     * @param $userId
     * @param $roomId
     * @param $direction
     * @param $messageId
     * @param $limit
     * @return array|Collection|mixed
     */
    public function getMessages($userId, $roomId, $direction, $messageId, $limit)
    {
        $query = $this->eloquentMessage->getModel()->where('room_id', $roomId);

        if ($messageId && $direction == 'newer') {
            $query->where('id', '>', $messageId);
        } elseif ($messageId) {
            $query->where('id', '<', $messageId);
        }

        $roomUser = $this->eloquentRoomUser->getModel()->where('room_id', $roomId)->get();
        if (count($roomUser) != 2) {
            return [];
        }

        $partnerId = $roomUser[0]->user_id;
        if ($partnerId == $userId) {
            $partnerId = $roomUser[1]->user_id;
        }

        $data = $query
            ->orderBy('id', $direction == 'older' ? 'desc' : 'asc')
            ->limit($limit)
            ->get();

        $cursor = $this->eloquentCursor->getModel()->where([
            'user_id' => (int)$partnerId,
            'room_id' => $roomId
        ])->first();

        if (!empty($cursor) && $cursor->type == RoomType::Twilio) {
            $cursor = data_get($cursor, 'message_index', null);

            $data = collect($data)->map(function ($item, $key) use ($cursor) {
                $item['read'] = false;
                if ($cursor && $item['index'] <= $cursor) {
                    $item['read'] = true;
                }
                return $item;
            })->toArray();
        } else {
            $cursor = data_get($cursor, 'message_id', null);

            $data = collect($data)->map(function ($item, $key) use ($cursor) {
                $item['read'] = false;
                if ($cursor && $item['id'] <= $cursor) {
                    $item['read'] = true;
                }
                return $item;
            })->toArray();
        }

        return $data;
    }

    /**
     * @param $userId
     * @param $roomId
     * @return int
     */
    public function getUnreadMessageNumber($userId, $roomId): int
    {
        $cursor = $this->eloquentCursor->getModel()->where([
            'user_id' => (int)$userId,
            'room_id' => $roomId
        ])->first();
        $unreadCountQuery = $this->eloquentMessage->getModel()->where([
            'room_id' => $roomId
        ]);

        if (!empty($cursor) && $cursor->type == RoomType::Twilio) {
            $cursor = data_get($cursor, 'message_index', null);

            if ($cursor) {
                $unreadCountQuery = $unreadCountQuery->where('index', '>', $cursor)
                    ->where('user_id', '<>', $userId);
            }
        } else {
            $cursor = data_get($cursor, 'message_id', null);
            if ($cursor) {
                $unreadCountQuery = $unreadCountQuery->where('id', '>', $cursor);
            }
        }

        return $unreadCountQuery->count();
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
        $userIdString = [(string)$userId, (string)$partnerId];
        $userIdInteger = [$userId, $partnerId];

        $roomUserIds = $this->eloquentRoomUser->getModel()->where('user_id', (string)$userId)->pluck('room_id')->toArray();
        $room = [];
        if (count($roomUserIds)) {
            $room = $this->eloquentRoom
                ->getModel()
                ->whereIn('id', $roomUserIds)->get()
                ->map(function ($room) {
                    return [
                        'id' => $room->id,
                        'user_ids' => $room->roomUsers->pluck('user_id')->toArray()
                    ];
                });
        }
        // Check room exist with user_id and partner_id
        $room = Arr::first($room, function ($value, $key) use ($userIdInteger) {
            return (count($userIdInteger) == count($value['user_ids']))
                && empty(array_diff($userIdInteger, $value['user_ids']));
        });

        if (!$room) {
            $data = $this->twilioService->getUsersByIds($userIdString);

            $existingUsersId = array_map(function ($user) {
                return (int)$user['id'];
            }, $data['body']);

            $notExistingUsersId = array_diff($userIdInteger, $existingUsersId);
            if (!empty($notExistingUsersId)) {
                $users = $this->eloquentUser->getModel()->whereIn('id', $notExistingUsersId)->get();
                $users = $users->map(function ($user) {
                    return [
                        'name' => ($user->name != "") ? $user->name : (string)$user->id,
                        'id' => (string)$user->id,
                        'email' => $user->email,
                    ];
                });

                $this->twilioService->createUsers($users->toArray());
            }

            $createRoom = $this->createNewRoom([
                'creator_id' => (string)$userId,
                'name' => 'Bachelor private room',
                'user_ids' => $userIdString,
                'private' => true,
                'custom_data' => []
            ]);

            $roomId = $createRoom['body']['id'];
            if (isset($roomId)) {
                // Check if room is not exist will create new
                $existRoom = $this->eloquentRoom->getModel()->where('id', $roomId)->first();
                if (empty($existRoom)) {
                    $createdRoom = $this->eloquentRoom->createRoom([
                        'room_id' => $roomId,
                        'name' => 'Bachelor private room',
                        'type' => RoomType::Twilio,
                        'created_by' => $userId,
                        'partner_id' => $partnerId
                    ]);

                    if (isset($createdRoom)) {
                        $this->eloquentRoomUser->getModel()->create(
                            [
                                'room_id' => $createdRoom->id,
                                'user_id' => $userId,
                                'type' => RoomType::Twilio
                            ]
                        );

                        $this->eloquentRoomUser->getModel()->create(
                            [
                                'room_id' => $createdRoom->id,
                                'user_id' => $partnerId,
                                'type' => RoomType::Twilio
                            ]
                        );
                    }
                }
            }
        } else {
            $roomId = $room['id'];
        }

        return [
            'data' => (string)$roomId,
            'user_id' => $userId
        ];
    }

    private function createNewRoom($roomInfo)
    {
        $room = $roomInfo;
        if (is_array($roomInfo) && isset($roomInfo['user_ids'])) {
            $userIds = $roomInfo['user_ids'];
            // sort array to create unique room name
            sort($userIds);
            $room['room_id'] = implode('_', $userIds);
        }

        $createRoom = $this->twilioService->createRoom($room);

        return $createRoom;
    }

    /**
     * @param array $filter
     * @return mixed
     */
    public function getRooms(array $filter)
    {
        $keySearch = $filter['search'];
        $roomIds = $this->eloquentRoomUser->filterRoomId($keySearch);
        return $this->eloquentRoom->getRooms($keySearch, $roomIds, Arr::get($filter, 'size', null));
    }

    /**
     * Get room detail
     *
     * @param int $id
     * @return mixed
     */
    public function getRoomDetail($id)
    {
        return $this->eloquentRoom->getModel()->with('users')
            ->with(array(
                'messages' => function ($query) {
                    $query->orderBy('id', 'DESC');
                }
            ))
            ->with('messages.user')->where(['id' => $id])->first();
    }

    /**
     * Get message list
     *
     * @param array $filter
     * @return array|Collection
     */
    public function searchMessage($filter): Collection
    {
        $message = $this->eloquentMessage->getModel()->with('user')
            ->with('room');
        if (!empty($filter)) {
            if ($filter['search'] && $filter['search'] != '') {
                $message = $message->where('text', 'like', "%" . $filter['search'] . "%");
            }
        }
        $message = $message->get();
        return $message;
    }
}
