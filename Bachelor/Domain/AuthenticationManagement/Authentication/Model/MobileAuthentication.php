<?php

namespace Bachelor\Domain\AuthenticationManagement\Authentication\Model;

use Bachelor\Domain\AuthenticationManagement\Authentication\Enums\UserAuthType;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserAuth;
use Bachelor\Port\Secondary\Database\UserManagement\UserInfoUpdatedTime\ModelDao\UserInfoUpdatedTime;
use Bachelor\Utility\Helpers\Utility;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;

class MobileAuthentication extends Authentication
{
    /*
     * @var Auth Id
     */
    private $mobileNumber;

    /*
     * @var query parameter passed to landing page
     */
    private $lpQueryStr;

    /**
     * AuthenticationService constructor.
     *
     * @param string $authId
     * @param string|null $lpQueryStr
     * @param string $authType
     * @throws BindingResolutionException
     */
    public function __construct (string $authId, ?string $lpQueryStr, string $authType = UserAuthType::Mobile)
    {
        parent::__construct( $authId, $authType );
        $this->mobileNumber = Utility::decode($this->authId);
        $this->lpQueryStr = $lpQueryStr;
    }

    /**
     * Retrieve User
     *
     * @param Builder $userAuthQueryBuilder
     * @return UserAuth
     */
    protected function retrieveUser(Builder $userAuthQueryBuilder) : UserAuth
    {
        return empty($this->userCount) ? $this->userService->createAndRetrieveNewUserAuth($this->authId, $this->createFirstUserData()) :
            $this->userService->updateAndRetrieveUserData($userAuthQueryBuilder, $this->getUserDataToUpdate());
    }

    /**
     * Get user auth data
     *
     * @return array
     */
    private function createFirstUserData()
    {
        if ($this->lpQueryStr && $this->lpQueryStr[0] == '?') $this->lpQueryStr = mb_substr($this->lpQueryStr, 1);

        $userId = User::factory()->create([
            'mobile_number' => $this->mobileNumber,
            'lp_query_str' => $this->lpQueryStr,
        ])->id;

        UserInfoUpdatedTime::factory()->create([
            'user_id' => $userId
        ]);

        return [
            'user_id' => $userId,
            'auth_id' => $this->authId,
            'auth_type' => UserAuthType::Mobile
        ];
    }

    /**
     * Get user data to update
     *
     * @return array
     */
    private function getUserDataToUpdate ()
    {
        return [
            'auth_type' => $this->authType,
            'auth_id' => $this->authId,
            'user' => [
                'mobile_number' => $this->mobileNumber,
            ]
        ];
    }
}
