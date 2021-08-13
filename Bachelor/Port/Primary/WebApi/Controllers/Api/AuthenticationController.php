<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Api;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SocialLoginRequest;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Bachelor\Application\User\Services\Interfaces\AuthenticationServiceInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class AuthenticationController
 * @package Bachelor\Port\Primary\WebApi\Controllers\Api
 *
 * @group User Authentication
 */
class AuthenticationController extends BaseController
{
    /**
     *  Redirect to facebook provider
     *
     * @param AuthenticationServiceInterface $authenticationService
     * @return RedirectResponse | JsonResponse
     *
     * @group Facebook Authentication
     * @url /api/v2/auth/login/facebook
     * @response 302 redirect to facebook provider
     */
    public function redirectToFacebookProvider(AuthenticationServiceInterface $authenticationService)
    {
        // Handle redirect to facebook provider
        return $authenticationService->redirectToFacebookProvider();
    }

    /**
     * Handle callback from facebook
     *
     * @param AuthenticationServiceInterface $authenticationService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|Redirect
     *
     * @group Facebook Authentication
     * @url api/v2/facebook/callback
     * @response 302 redirect env('WEB_APP_LOGIN_URL')."?authId=&authType=".$params['authType']."&newUser=&duplicateUser="
     */
    public function handleFacebookProviderCallback(AuthenticationServiceInterface $authenticationService)
    {
        // Handle redirect facebook callback
        return redirect($authenticationService->handleFacebookCallback());
    }

    /**
     * Redirect to line provider
     *
     * @param Request $request
     * @param AuthenticationServiceInterface $authenticationService
     * @return \Illuminate\Contracts\Foundation\Application|JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * @group Line Authentication
     * @url /api/v2/auth/login/line
     * @response 302 redirect to line provider
     */
    public function redirectToLineProvider(Request $request, AuthenticationServiceInterface $authenticationService)
    {
        // Redirect to line provider
        return redirect($authenticationService->redirectToLineProvider($request));
    }

    /**
     * Handle line provider callback
     *
     * @param Request $request
     * @param AuthenticationServiceInterface $authenticationService
     * @return \Illuminate\Contracts\Foundation\Application|JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * @group Line Authentication
     * @url api/v2/line/callback
     * @response 302 redirect env('WEB_APP_LOGIN_URL')."?authId=&authType=".$params['authType']."&newUser=&duplicateUser="
     */
    public function handleLineProviderCallback(Request $request, AuthenticationServiceInterface $authenticationService)
    {
        // retrieve the code sent via line
        $code = request('code');

        if (!is_null($code))
            // Handle Line callback and re
            return redirect($authenticationService->handleLineCallback($code));

        // else redirect user to login
        redirect(env('WEB_APP_LOGIN_URL'));
    }

    /**
     * Api to authenticate user
     *
     * @param SocialLoginRequest $request
     * @param AuthenticationServiceInterface $authenticationService
     * @return JsonResponse
     *
     * @url api/v2/social-login
     * @urlParam authId string required The authentication id of the user
     * @urlParam authType string required The authentication type of the user
     * @response 200 {
     * "message": "User Login Successfully",
        "data": {
            "userAuth": {
            "id": 1,
            "user_id": 2,
            "auth_type": "Mobile",
            "auth_id": "aDZhYWtBaUFNYWFtbE80MFAwZXN6QT09",
            "access_token": null,
            "token": {
            "token_type": "Bearer",
            "expires_in": 31536000,
            "access_token": "",
            "refresh_token": ""
        },
        "user": {
            "id": 2,
            "name": null,
            "gender": 1,
            "email": null,
            "mobile_number": "0967253526",
            "status": 1,
            "registration_steps": 0,
            "prefecture_id": 1,
            "support_tracking_url": null,
            "team_member_rate": 0,
            "flex_point": 0,
            "cost_plan": "normal",
            "is_fake": 0,
            "invitation_code": null,
            "invitation_url": null
        }
        },
            "needs_mobile_number_verification": false,
            "user_prefecture_status": true,
            "socialLoginLink": "http://bachelor-backend.test/auto-login?login_code=Yms1MzFtL0NMMytXeVJvbXkvNnZ1NTdlb2dRTEdKNnVuWFFvL044TkNQMkJ5YU1UbTdUSkszaG5IVHBmN2p3RGd4Y0tpdmt3aFliamlzQVp4aU1HUkxkTzc0R0NITkVYVURxVlBuUVoxY0E9",
            "status": 1,
            "message": "Please complete your profile and submit for review."
        }
      }
     * @response 512 {
     *      "message":"Error Encountered while logging-in user in  \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/AuthenticationController.php at 244 due to `Exception message`",
     *      "data":[]
     *  }
     * @response 515 {
     *      "message":"Duplicate User Found",
     *      "data":[]
     *  }
     */
    public function socialLogin(SocialLoginRequest $request, AuthenticationServiceInterface $authenticationService): JsonResponse
    {
        // Login user if exists or create new user
        $response = $authenticationService->socialLogin(
            $request->authId,
            $request->authType,
            $request->lpQueryStr
        );

        // set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }

    /**
     * Used to logout user
     *
     * @return JsonResponse
     *
     * @url /api/v2/user/logout
     * @response 302 env('WEB_APP_LOGIN_URL') Redirect to login page of webapp
     */
    public function logout():JsonResponse
    {
        if (Auth::check()) {
            Auth::user()->token()->revoke();
            $this->status = Response::HTTP_OK;
            $this->message = "Successfully logged out";
        }

        return ApiResponseHandler::jsonResponse(Response::HTTP_OK, $this->message,  $this->data);
    }
}
