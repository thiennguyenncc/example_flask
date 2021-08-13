<?php

namespace Bachelor\Domain\AuthenticationManagement\Authentication\Factories;

use Bachelor\Domain\AuthenticationManagement\Authentication\Model\MobileAuthentication;
use Bachelor\Domain\AuthenticationManagement\Authentication\Services\Interfaces\AuthServiceInterface;

class AuthType
{
    /**
     * Instantiate user type
     *
     * @param string $authId
     * @param string $authType
     * @return AuthServiceInterface
     */
    public static function instantiate( string $authType, string $authId = '', ?string $lpQueryStr = null) : AuthServiceInterface
    {
        $authenticateService = 'Bachelor\\Domain\\AuthenticationManagement\\Authentication\\Model\\'.$authType.'Authentication';
        return $authType == 'Mobile' ? new $authenticateService($authId, $lpQueryStr) :  new $authenticateService($authId);
    }
}
