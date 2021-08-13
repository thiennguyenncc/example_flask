<?php

namespace Bachelor\Port\Secondary\AuthenticationManagement\Line\Repository;

use Bachelor\Port\Secondary\AuthenticationManagement\Line\Interfaces\LineRequestInterface;

class LineRequest implements LineRequestInterface
{
    /*
    * Line Api endpoint
    */
    private $endpoint;

    /**
     * LineApi constructor.
     */
    public function __construct ()
    {
        $this->endpoint = config('services.line.endpoint');
    }

    /**
     * Grant access taken
     *
     * @param $code
     * @param $channelId
     * @param $channelSecret
     * @param $callbackUrl
     * @return array
     */
    public function accessTokenRequest(string $code, string $channelId,string $channelSecret, string $callbackUrl) : array
    {
        return array(
            'Url' => $this->endpoint."oauth2/v2.1/token",
            'Method' => 'post',
            'Header' => 'Content-Type: application/x-www-form-urlencoded',
            'Body' => array(
                urlencode('grant_type')=>urlencode('authorization_code'),
                urlencode('code')=>urlencode($code),
                urlencode('redirect_uri')=>urlencode($callbackUrl),
                urlencode('client_id')=>urlencode($channelId),
                urlencode('client_secret')=>urlencode($channelSecret)
            ));
    }

    /**
     * Get Line user profile
     *
     * @param $accessToken
     * @return array
     */
    public function lineUserProfile(string $accessToken) : array
    {
        return array(
            'Url' => $this->endpoint."v2/profile",
            'Method' => 'get',
            'Header' => "Authorization: Bearer " . $accessToken,
            'Body' => array());
    }
}
