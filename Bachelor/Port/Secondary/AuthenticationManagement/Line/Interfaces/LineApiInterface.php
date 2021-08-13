<?php

namespace Bachelor\Port\Secondary\AuthenticationManagement\Line\Interfaces;

interface LineApiInterface
{
    /**
     * Get Line web login
     *
     * @return string
     */
    public static function getLineWebLoginUrl() : string ;

    /**
     * Get Line login with add bot
     *
     * @return string
     */
    public static function getLineWebLoginUrlWithAddBoot() : string ;

    /**
     * Generate access token
     *
     * @param $code
     * @return LineApiInterface
     */
    public function accessToken(string $code) : LineApiInterface;

    /**
     * Line Profile
     *
     * @return array
     */
    public function profile() : array;
}
