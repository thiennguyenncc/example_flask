<?php

namespace Bachelor\Domain\AuthenticationManagement\Authentication\Services\Interfaces;

interface AuthServiceInterface
{
    /**
     * Retrieve user for authentication
     */
    public function retrieveUserAndAuthenticate() : array ;

}
