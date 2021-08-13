<?php

namespace Bachelor\Application\User\Services\Interfaces;

use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

interface AuthenticationServiceInterface
{
    /**
     * Api to authenticate user
     *
     * @param string $authId
     * @param string $authType
     * @param string|null $lpQueryStr
     * @return array
     */
    public function socialLogin(string $authId, string $authType, ?string $lpQueryStr) : array ;

    /**
     *  Handle redirection to facebook provider
     */
    public function redirectToFacebookProvider() : RedirectResponse;

    /**
     * Redirect to Line provider
     *
     * @param Request $request
     * @return mixed
     */
    public function redirectToLineProvider(Request $request) : string ;

    /**
     * Handle callback from facebook
     */
    public function handleFacebookCallback() : string ;

    /*
     * Handle callback from line
     */
    public function handleLineCallback(string $code) : string ;

}
