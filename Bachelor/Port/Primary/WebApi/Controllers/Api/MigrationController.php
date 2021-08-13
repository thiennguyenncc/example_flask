<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Api;

use App\Http\Requests\MigrationRequest;
use Bachelor\Application\User\Services\UserService;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class MigrationController
 * @package Bachelor\Port\Primary\WebApi\Controllers\Api
 *
 * @User Migration
 */
class MigrationController extends BaseController
{
    /**
     * User for account migration from line or fb to Auth
     *
     * @param MigrationRequest $request
     * @param UserService $userService
     * @return JsonResponse
     *
     * @url /api/v2/user/migrate-account
     * @bodyParam mobileNumber string required The mobile number of the user who wants to migrate the account. Example: 09272663636
     * @response 302 redirect to social-login for re-authentication
     * @response 512 {
     *      "message":"Error Encountered while migrating account in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/MigrationController.php at 52 due to `Exception message`",
     *      "data":[]
     *  }
     */
    public function migrateAccount(MigrationRequest $request, UserService $userService)
    {
        try {
            // Retrieve mobile number
            $mobileNumber = $request->mobileNumber;

            if (!empty($mobileNumber)) {
                // Get the account to migrate data to
                $authAccountToMigrate = Auth::user()->getDomainEntity();

                // Migrate user account and redirect for authentication
                return redirect($userService->handleUserAccountMigration($authAccountToMigrate, $mobileNumber));
            }
        } catch (Exception $exception) {

            DB::rollBack();
            throw $exception;
        }

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }
}
