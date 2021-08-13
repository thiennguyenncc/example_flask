<?php

namespace App\Http\Middleware;

use Bachelor\Utility\ResponseCodes\ApiCodes;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * @param Request $request
     * @param array $guards
     */
    protected function unauthenticated($request, array $guards)
    {
        (new JsonResponse([
            'message' => 'Unauthorized',
            'data' => []
        ], ApiCodes::SOMETHING_WENT_WRONG))->throwResponse();
    }
}
