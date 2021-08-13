<?php

namespace Bachelor\Domain\AuthenticationManagement\Authentication\Model;

use Bachelor\Domain\AuthenticationManagement\Authentication\Enums\UserAuthType;
use Illuminate\Contracts\Container\BindingResolutionException;

class FacebookAuthentication extends Authentication
{

    /**
     * AuthenticationService constructor.
     *
     * @param string $authId
     * @param string $authType
     * @throws BindingResolutionException
     */
    public function __construct (string $authId, string $authType = UserAuthType::Facebook)
    {
        parent::__construct($authId, $authType);
    }

}
