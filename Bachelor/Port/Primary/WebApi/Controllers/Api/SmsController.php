<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Api;

use Bachelor\Application\User\Services\Interfaces\SmsServiceInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\SendCodeRequest;
use App\Http\Requests\CodeVerificationRequest;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;

/**
 * Class SmsController
 * @package Bachelor\Port\Primary\WebApi\Controllers\Api
 *
 * @group Sms
 */
class SmsController extends BaseController
{

    /**
     * Handle send verification code request
     *
     * @param SendCodeRequest $request
     * @param SmsServiceInterface $smsService
     * @return JsonResponse
     *
     * @group Sms Authentication
     * @url /api/v2/send-verification-code
     * @bodyParam mobileNumber string required Mobile Number to which verification code will be sent. Example: 09563778387
     * @bodyParam country string required The country to which the number belongs to. Example: Japan
     * @response 200 {
     *      "message":"Code sent successfully",
     *      "data":[]
     *  }
     * @response 512 {
     *      "message":"Error Encountered while sending verification code in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/SmsController.php at 43 due to `Exception message`",
     *      "data":[]
     *  }
     */
    public function sendVerificationCode( SendCodeRequest $request , SmsServiceInterface $smsService)
    {
        // Initialize and send verification code to the user
        $response = $smsService->sendVerificationCodeToUser($request->all());

        // set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }

    /**
     * Api to verify code
     *
     * @param CodeVerificationRequest $request
     * @param SmsServiceInterface $smsService
     * @return JsonResponse
     *
     * @group Sms Authentication
     * @url /api/v2/verify-code
     * @bodyParam mobileNumber string required Mobile Number that needs to be verified. Example: 09826266625
     * @bodyParam country string required The country to which the number belongs to. Example: Japan
     * @bodyParam verificationCode string required The verification code to validate the number. Example: 1111
     * @response 302 redirect env('WEB_APP_LOGIN_URL')."?authId=".Utility::encode($smsService->getMobileNumber())."&authType=".$params['authType']."&newUser=&duplicateUser="
     * @response 512 {
     *      "message":"Error Encountered while verifying code in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/SmsController.php at 100 due to `Exception message`",
     *      "data":[]
     *  }
     * @response 513 {
     *      "message":"Not a valid verification code",
     *      "data":[]
     *  }
     */
    public function verifyCode(CodeVerificationRequest $request , SmsServiceInterface $smsService)
    {
        // Verify user code
        $response = $smsService->verifyCode($request->all());

        // set api response
        self::setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }
}
