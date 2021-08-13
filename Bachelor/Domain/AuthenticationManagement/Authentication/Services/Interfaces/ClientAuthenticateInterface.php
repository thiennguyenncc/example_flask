<?php

namespace Bachelor\Domain\AuthenticationManagement\Authentication\Services\Interfaces;

use Bachelor\Domain\AuthenticationManagement\Authentication\Services\AuthenticateUser;

interface ClientAuthenticateInterface
{
    /**
     * Authenticate user
     *
     * @return AuthenticateUser
     */
    public function signIn() : AuthenticateUser;

    /**
     * Respond after user authentication
     *
     * @return array
     */
    public function respondAfterAuthentication() : array ;
}
