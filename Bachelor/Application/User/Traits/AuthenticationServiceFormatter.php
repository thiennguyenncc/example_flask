<?php

namespace Bachelor\Application\User\Traits;

use Bachelor\Domain\AuthenticationManagement\Authentication\Enums\UserAuthType;

trait AuthenticationServiceFormatter
{
    /**
     * get formatted data to handle facebook callback
     *
     * @return array
     */
    protected function formatDataToHandleFacebookCallback() : array
    {
        return [
            'authType' =>  UserAuthType::Facebook
        ];
    }
}
