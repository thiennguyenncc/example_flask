<?php


namespace Bachelor\Port\Secondary\Communication\Twilio\Repository;


use Bachelor\Port\Secondary\Communication\Twilio\Interfaces\TwilioServiceInterface;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\RestException;
use Twilio\Exceptions\TwilioException;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;
use Twilio\Rest\Chat\V2\ServiceContext;
use Twilio\Rest\Client;

class TwilioService implements TwilioServiceInterface
{
    /**
     * @var ServiceContext
     */
    protected $twilioService;

    /**
     * @var Repository|Application|mixed
     */
    protected $accountSid;

    /**
     * @var Repository|Application|mixed
     */
    protected $authId;

    /**
     * @var Repository|Application|mixed
     */
    protected $chatServiceId;

    /**
     * @var Repository|Application|mixed
     */
    protected $apiKey;

    /**
     * @var Repository|Application|mixed
     */
    protected $secretApiKey;

    /**
     * TwilioService constructor.
     */
    public function __construct()
    {
        $this->accountSid = config('twilio.account_sid');
        $this->authId = config('twilio.auth_key');
        $this->chatServiceId = config('twilio.chat_service_id');
        $this->apiKey = config('twilio.api_key');
        $this->secretApiKey = config('twilio.secret_api_key');

        try {
            $twilio = new Client($this->accountSid, $this->authId);
            $this->twilioService = $twilio->chat->v2->services(config('twilio.chat_service_id'));
        } catch (ConfigurationException $e) {
            Log::error($e->getMessage());
        }
    }


    private function generateAcceptToken($identity = ''): AccessToken
    {
        $accessToken = '';

        try {
            $accessToken = new AccessToken($this->accountSid, $this->apiKey, $this->secretApiKey, 3600, $identity);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        return $accessToken;
    }

    private function generateChatGrant(): ChatGrant
    {
        $chatGrant = new ChatGrant();
        $chatGrant->setServiceSid($this->chatServiceId);

        return $chatGrant;
    }

    private function generateTokenTwilio($accessToken, $chatGrant)
    {
        $accessToken->addGrant($chatGrant);

        return $accessToken->toJWT();
    }

    public function getToken($identity): array
    {
        $token = $this->generateAcceptToken($identity);
        $chatGrant = $this->generateChatGrant();
        $twilioToken = $this->generateTokenTwilio($token, $chatGrant);

        return [
            'code' => Response::HTTP_OK,
            'message' => 'Get Twilio token success',
            'data' => [
                'token' => $twilioToken,
                'identity' => $identity
            ]
        ];
    }

    /**
     * Get users by ids
     *
     * @param array $ids
     * @return array
     * @throws TwilioException
     */
    public function getUsersByIds(array $ids): array
    {
        $data['body'] = [];

        if (count($ids)) {
            foreach ($ids as $id) {
                try {
                    $dataUser = [];
                    $user = $this->twilioService->users($id)->fetch();
                    $dataUser['id'] = $user->identity;
                    $data['body'][] = $dataUser;
                } catch (RestException $ex) {
                    Log::error($ex->getMessage());
                }

            }
        }

        return $data;
    }

    /**
     * Get channels
     *
     * @param string $type
     * @return array
     */
    public function getChannels($type = 'private'): array
    {
        $data['body'] = [];

        try {
            $channels = $this->twilioService->channels->read(['type' => $type], 1000);
            $data['body'] = $channels;
        } catch (RestException $ex) {
            Log::error($ex->getMessage());
        }

        return $data;
    }

    /**
     * Get members in room
     *
     * @param int $roomId
     * @return array
     */
    public function getMembers(int $roomId): array
    {
        $data['body'] = [];

        if (! empty($roomId)) {
            try {
                $members = $this->twilioService->channels($roomId)->members->read([], 2);
                $data['body'] = $members;
            } catch (RestException $ex) {
                Log::error($ex->getMessage());
            }
        }

        return $data;
    }

    /**
     * Get member
     *
     * @param string|null $roomId
     * @param int|null $userId
     * @return array
     * @throws TwilioException
     */
    public function getMember($roomId = null, int $userId = null): array
    {
        $data['body'] = null;

        if (! empty($roomId) && ! empty($userId)) {
            try {
                $member = $this->twilioService->channels($roomId)->members($userId)->fetch();
                $data['body'] = $member;
            } catch (RestException $ex) {
                Log::error($ex->getMessage());
            }
        }

        return $data;
    }

    /**
     * Get room messages
     *
     * @param array $query
     * @return array
     */
    public function getRoomMessages(array $query): array
    {
        $data['body'] = [];

        if (count($query) && isset($query['room_id'])) {
            $messages = $this->twilioService->channels($query['room_id'])->messages->read([], 1000);
            $data['body'] = $messages;
        }

        return $data;
    }

    /**
     * Create room
     *
     * @param array $roomInfo
     * @return array
     * @throws TwilioException
     */
    public function createRoom(array $roomInfo): array
    {
        $data['body']['id'] = null;

        if (count($roomInfo)) {
            try {
                // Create channel
                $channel = $this->twilioService->channels->create(
                    [
                        'uniqueName' => isset($roomInfo['room_id']) ? $roomInfo['room_id'] : null,
                        'friendlyName' => isset($roomInfo['name']) ? $roomInfo['name'] : null,
                        'createdBy' => isset($roomInfo['creator_id']) ? (int)$roomInfo['creator_id'] : null,
                        'attributes' => isset($roomInfo['custom_data']) ? $roomInfo['custom_data'] : null,
                        'type' => isset($roomInfo['private']) ? 'private' : 'public',
                    ]);

                if ($channel && $channel->sid) {
                    // Add members to channel
                    if (isset($roomInfo['user_ids']) && count($roomInfo['user_ids'])) {
                        foreach ($roomInfo['user_ids'] as $user_id) {
                            $this->twilioService->channels($channel->sid)->members->create($user_id);
                        }

                    }
                }

                if ($channel && $channel->uniqueName) {
                    $data['body']['id'] = $channel->uniqueName;
                }

            } catch (RestException $ex) {
                // When room is created on twilio it return room_id
                if ($ex->getStatusCode() == 409) {
                    $data['body']['id'] = isset($roomInfo['room_id']) ? $roomInfo['room_id'] : null;
                }

                Log::error($ex->getMessage());
            }
        }

        return $data;
    }

    public function createUsers(array $users): array
    {
        $data['body'] = [];

        if (count($users)) {
            foreach ($users as $user) {
                try {
                    $dataUser = [];

                    if (isset($user['id']) && isset($user['name'])) {
                        $user = $this->twilioService->users->create($user['id'],
                            [
                                'friendlyName' => isset($user['email']) ? $user['email'] : $user['name'],
                            ]);
                        $dataUser['id'] = $user->identity;
                        $data['body'][] = $dataUser;
                    }
                } catch (RestException $ex) {
                    Log::error($ex->getMessage());
                }

            }
        }

        return $data;
    }
}
