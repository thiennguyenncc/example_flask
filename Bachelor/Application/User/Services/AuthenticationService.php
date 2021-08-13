<?php

namespace Bachelor\Application\User\Services;

use Bachelor\Application\User\Services\Interfaces\AuthenticationServiceInterface;
use Bachelor\Application\User\Traits\AuthenticationServiceFormatter;
use Bachelor\Domain\AuthenticationManagement\Authentication\Factories\AuthType;
use Bachelor\Domain\AuthenticationManagement\Facebook\Services\FacebookService;
use Bachelor\Domain\AuthenticationManagement\Line\Services\LineService;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthenticationService implements AuthenticationServiceInterface
{
    use AuthenticationServiceFormatter;

    /*
     * @var LineInterface
     */
    private $line;

    /*
     * @var FacebookInterface
     */
    private $facebook;

    /**
     * AuthenticationService constructor.
     * @param FacebookService $facebook
     * @param LineService $line
     */
    public function __construct (FacebookService $facebook, LineService $line)
    {
        $this->facebook = $facebook;
        $this->line = $line;
    }

    /**
     * Api to authenticate user
     *
     * @param string $authId
     * @param string $authType
     * @param string $abm
     * @return array
     */
    public function socialLogin (string $authId, string $authType, ?string $lpQueryStr) : array
    {
        // Handle social Login
        // Instantiate the authentication service based on auth type and retrieve the user
        return AuthType::instantiate($authType, $authId, $lpQueryStr)->retrieveUserAndAuthenticate();
    }

    /**
     *  Handle redirection to facebook provider
     */
    public function redirectToFacebookProvider() :RedirectResponse
    {
        // redirect to facebook provider
        return $this->facebook->handleRedirectToFacebookProvider();
    }

    /**
     * Redirect to Line provider
     *
     * @param Request $request
     * @return mixed
     */
    public function redirectToLineProvider(Request $request) : string
    {
        // Redirect to line provider
        return $this->line->redirectToLineProvider();
    }

    /**
     * Handle callback from facebook
     */
    public function handleFacebookCallback() : string
    {
       // Handle facebook oauth callback
       return $this->facebook->handleOauthCallbackFromFacebook(self::formatDataToHandleFacebookCallback());
    }

    /*
     * Handle callback from line
     *
     * @param $code
     */
    public function handleLineCallback(string $code) : string
    {
        // Handle line oauth callback
        return $this->line->handleLineCallback($code);
    }

}
