<?php

namespace Bachelor\Port\Secondary\AuthenticationManagement\Line\Repository;

use Bachelor\Port\Secondary\AuthenticationManagement\Line\Interfaces\LineApiInterface;
use Bachelor\Port\Secondary\AuthenticationManagement\Line\Interfaces\LineRequestInterface;
use Bachelor\Utility\Helpers\CurlClient;
use Illuminate\Contracts\Container\BindingResolutionException;
use Bachelor\Utility\Helpers\Log;
use Illuminate\Support\Str;

class LineApi implements LineApiInterface
{

    /**
     * @var LineRequestInterface
     */
    private $line;

    /*
     * Line Client Id
     */
    private $channelId;

    /*
     * Line Client Secret
     */
    private $channelSecret;

    /*
     * Line callback
     */
    private $callbackUrl;

    /*
     * Encoded callback url
     */
    private $encodedCallbackUrl;

    /*
     * Response
     */
    private $response;

    /*
     * Access token
     */
    private $accessToken;

    /**
     * MobileAuthServiceProvider constructor.
     * @throws BindingResolutionException
     */
    public function __construct ()
    {
        $this->line = app()->make(LineRequestInterface::class);
        $this->channelId = env('LINE_CHANNEL_ID');
        $this->channelSecret = env('LINE_CHANNEL_SECRET');
        $this->callbackUrl = env('LINE_CALLBACK_URL');
        $this->encodedCallbackUrl = urlencode($this->callbackUrl);

    }

    /**
     * Get Line web login
     *
     * @return string
     */
    public static function getLineWebLoginUrl() : string
    {
        $encodedCallbackUrl = urlencode(env('LINE_CALLBACK_URL'));

        // Site Forgery
        $state = Str::random(40);

        request()->session()->put('state', $state);

        $client_id = env('LINE_CHANNEL_ID');

        return "https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=".$client_id."&redirect_uri=".$encodedCallbackUrl."&state=" . $state . "&scope=email%20openid%20profile";
    }

    /**
     * Get Line login with add bot
     *
     * @return string
     */
    public static function getLineWebLoginUrlWithAddBoot() : string
    {
        $encodedCallbackUrl = urlencode(env('LINE_CALLBACK_URL'));

        // Site Forgery
        $state = Str::random(40);

        request()->session()->put('state', $state);

        $client_id = env('LINE_CHANNEL_ID');

        return "https://access.line.me/oauth2/v2.1/authorize?response_type=code&client_id=".$client_id."&redirect_uri=".$encodedCallbackUrl."&state=" . $state . "&scope=email%20openid%20profile";
    }


    /**
     * Get Guzzle client for line
     *
     * @param $data
     * @return mixed
     */
    private function getClient($data)
    {
        Log::info("Instantiate Guzzle Client for Line authorization: " . json_encode($data));

        $output = '';

        if ($data['Method'] == 'post')
            $output = CurlClient::post($data['Url'], $data['Header'], $data['Body']);

        elseif ($data['Method'] == 'get')
            $output = CurlClient::get($data['Url'], $data['Header']);


        Log::info("LineAPIService.getClient: " . $output);

        return $output;
    }

    /**
     * Generate access token
     *
     * @param $code
     * @return LineApiInterface
     */
    public function accessToken(string $code) : LineApiInterface
    {
        // Access token found
        $this->response = json_decode(self::getClient($this->line->accessTokenRequest($code, $this->channelId, $this->channelSecret, $this->callbackUrl)), true);

        $this->accessToken = $this->response['access_token'];

        return $this;
    }

    /**
     * Obtain user profile from line
     *
     * @return array
     */
    public function profile() : array
    {
        // Get request to obtain line user profile
        return json_decode(self::getClient($this->line->lineUserProfile($this->accessToken)), true);
    }

}
