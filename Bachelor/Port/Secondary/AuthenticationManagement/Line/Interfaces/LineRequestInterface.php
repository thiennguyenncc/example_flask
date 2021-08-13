<?php

namespace Bachelor\Port\Secondary\AuthenticationManagement\Line\Interfaces;

interface LineRequestInterface
{
    /**
     * Grant access taken
     *
     * @param $code
     * @param $channelId
     * @param $channelSecret
     * @param $callbackUrl
     * @return array
     */
    public function accessTokenRequest(string $code, string $channelId, string $channelSecret,string $callbackUrl) : array ;

    /**
     * Get Line user profile
     *
     * @param $accessToken
     * @return array
     */
    public function lineUserProfile(string $accessToken) : array ;
}
