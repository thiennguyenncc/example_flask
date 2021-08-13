<?php

namespace Bachelor\Domain\AuthenticationManagement\Authentication\Factories;

use Bachelor\Domain\AuthenticationManagement\Authentication\Services\Interfaces\OauthServiceProviderInterface;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserAuth;

class OauthServiceType
{
    /**
     * Instantiate oauth service provider
     *
     * @param string $oauthType
     * @param UserAuth $userAuth
     * @return mixed
     */
    public static function instantiateOauthServiceProvider ( string $oauthType, UserAuth $userAuth ) : OauthServiceProviderInterface
    {
        $oauthServiceProvider = 'Bachelor\\Domain\\AuthenticationManagement\\Authentication\\Services\\'.ucfirst($oauthType).'OauthServiceProvider';
        return new $oauthServiceProvider($userAuth);
    }
}
