<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Api;

use App\Http\Requests\Webhook\StripeWebhookRequest;
use Bachelor\Application\User\Services\StripeWebhookService;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Bachelor\Utility\Helpers\Log;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class StripeWebhookController
 * @package Bachelor\Port\Primary\WebApi\Controllers\Api
 *
 * @group Stripe Webhook
 */
class StripeWebhookController extends BaseController
{
    /**
     * Handle stripe webhook
     *
     * @param Request $request
     * @param StripeWebhookService $stripeService
     * @return JsonResponse
     *
     * @url api/v2/webhook/stripe
     * @response 200 {
     *      "message":"Successfully",
     *      "data":[]
     *  }
     * @response 512 {
     *      "message":"'Error Encountered while performing '.$method. in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/StripeWebhookController.php at 50 due to `Exception message`",
     *      "data":[]
     *  }
     */
    public function webhook(StripeWebhookRequest $request, StripeWebhookService $stripeService)
    {
        $params = $request->all();
        $method = 'handle' . Str::studly(str_replace('.', '_', $params['type']));
        Log::channel('stripe')->info('Stripe webhook called', ['method' => $method, 'request' => $params]);

        DB::beginTransaction();
        try {

            // If method doesn't exist
            if (!method_exists($stripeService, $method)) {
                $this->status = Response::HTTP_BAD_REQUEST;
                throw new Exception($method . ' method is not found');
            }

            // Handle the specified stripe webhook
            $response = $stripeService->$method($params['data']['object'], $params['data']['previous_attributes'] ?? null);

            DB::commit();
            // set api response
            $this->setResponse($response['status'], $response['message'], $response['data']);
        } catch (Exception $e) {

            DB::rollback();
            if (!App::environment('production')) {
                $this->setResponse(Response::HTTP_OK, "this is dummy success for testing environment while performing " . $method, [$e->getMessage(),$e->getFile(),$e->getLine()]);
            } else {
                throw $e;
            }
        }

        return ApiResponseHandler::jsonResponse($this->status, $this->message,  $this->data);
    }
}
