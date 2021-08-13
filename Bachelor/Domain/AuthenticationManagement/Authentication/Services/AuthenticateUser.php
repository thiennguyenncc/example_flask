<?php

namespace Bachelor\Domain\AuthenticationManagement\Authentication\Services;

use Bachelor\Domain\AuthenticationManagement\Authentication\Enums\OauthType;
use Bachelor\Domain\AuthenticationManagement\Authentication\Factories\OauthServiceType;
use Bachelor\Domain\AuthenticationManagement\Authentication\Services\Interfaces\ClientAuthenticateInterface;
use Bachelor\Domain\UserManagement\User\Services\UserDomainService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserAuth;
use Bachelor\Port\Secondary\Database\UserManagement\User\Interfaces\EloquentUserAuthInterface;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateUser implements ClientAuthenticateInterface
{

    /*
     * Authenticated user
     */
    private $userAuth;

    /**
     * @var UserDomainService
     */
    private $user;

    /**
     * @var EloquentUserAuthInterface
     */
    private $userAuthRepository;

    /**
     * AuthenticateUser constructor.
     * @param UserAuth $userAuth
     * @throws BindingResolutionException
     */
    public function __construct (UserAuth $userAuth)
    {
        $this->userAuth = $userAuth;
        $this->user = app()->make(UserDomainService::class);
        $this->userAuthRepository = app()->make(EloquentUserAuthInterface::class);
    }

    /**
     * Authenticate user
     *
     * @return AuthenticateUser
     */
    public function signIn ( ) : AuthenticateUser
    {
        // Remove all previously allocated token
        $this->userAuth->oauthAccessToken()->delete();

        // Initialize Oauth service provider and get the access token
        $this->userAuth->token = OauthServiceType::instantiateOauthServiceProvider(OauthType::Passport, $this->userAuth)
            ->generateAccessToken($this->userAuth);

        // Log when user logs in to the system
        $this->userAuthRepository->logUserLogin($this->userAuth);

        return $this;
    }

    /**
     * Redirect user after authentication
     *
     * @return array
     */
    public function respondAfterAuthentication () :array
    {
        return [
            'status' => Response::HTTP_OK,
            'message' => __('api_auth.user_login_successfully'),
            'data' => $this->user->retrieveUserDataAfterAuthentication($this->userAuth)
        ];
    }
}
