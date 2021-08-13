<?php

namespace Bachelor\Port\Primary\WebApi\Controllers\Api;

use App\Http\Requests\User\PaymentCard\CreateUserCardRequest;
use Bachelor\Port\Primary\WebApi\Controllers\BaseController;
use Bachelor\Port\Primary\WebApi\ResponseHandler\Api\ApiResponseHandler;
use Bachelor\Application\User\Services\PaymentCardService;
use Illuminate\Http\JsonResponse;
use Exception;

/**
 * Class UserCardController
 * @package Bachelor\Port\Primary\WebApi\Controllers\Api
 *
 * @group User Card
 */
class UserCardController extends BaseController
{

    /**
     * List all user cards
     *
     * @param PaymentCardService $PaymentCardService
     * @return JsonResponse
     *
     * @group User Cards
     * @url /api/v2/user/user-cards
     *
     * @response 200 {
     *      "message":"Successfully fetched list of user cards",
     *      "data":[{
     *      "id": 1,
     *      "user_id": 1,
     *      "payment_provider_id": 1,
     *      "third_party_card_id": "card_1Hk4omGOGj3Av1fnEoeIAyoT",
     *      "card_last_four_digits": 4242,
     *      "is_primary": true
     *  }]
     *  }
     * @response 512 {
     *      "message":"Error encountered while listing user card in in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/UserCardController.php at 43 due to `Exception message`",
     *      "data":[]
     *  }
     */
    public function index(PaymentCardService $PaymentCardService): JsonResponse
    {
        // Fetch user cards
        $response = $PaymentCardService->getUserCards();

        // set api response
        $this->setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * Add new user card
     *
     * @param CreateUserCardRequest $request
     * @param PaymentCardService $PaymentCardService
     * @return JsonResponse
     *
     * @group User Cards
     * @url /api/v2/user/user-cards
     * @bodyParam cardNumber numeric required Credit card or debit card number minimum 6 digits. Example: 4242424242424242
     * @bodyParam cvv numeric required Card security number between 3 to 4 digits. Example: 663
     * @bodyParam expiryMonth numeric Card expiry month required 2 digits. Example: 01
     * @bodyParam expiryYear numeric Card expiry year required 4 digits. Example: 2024
     * @bodyParam paymentGateway string required Type of payment gateway used. Example: stripe
     * @bodyParam source string required Token generated from stripe.js. Example: tok_mastercard, tok_visa, tok_visa_debit
     *
     * @response 200 {
     *      "message":"Successfully added new card",
     *      "data":{
     *       "user_id": 1,
     *       "payment_provider_id": 1,
     *       "third_party_card_id": "card_1HmB3HGOGj3Av1fnXW6jk75T",
     *       "card_last_four_digits": "4242"
     *       "id": 4
     *   }
     *  }
     * @response 512 {
     *      "message":"Error encountered while create new user card in in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/UserCardController.php at 43 due to `Exception message`",
     *      "data":[]
     *  }
     */
    public function store(CreateUserCardRequest $request, PaymentCardService $PaymentCardService): JsonResponse
    {
        // Create new card
        $response = $PaymentCardService->storeNewPaymentCard($request->all());

        // set api response
        $this->setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * Set default user card
     *
     * @param PaymentCardService $PaymentCardService
     * @param int $cardId
     * @return JsonResponse
     *
     * @group User Cards
     * @url /api/v2/user/user-cards/set-default
     * @urlParam cardId numeric required User card id. Example: 1
     *
     * @response 200 {
     *      "message":"Successfully set card as default",
     *      "data":{
                "id": 1,
                "user_id": 1,
                "payment_provider_id": 1,
                "third_party_card_id": "card_1Hk4omGOGj3Av1fnEoeIAyoT",
                "card_last_four_digits": 4242
            }
     *  }
     * @response 512 {
     *      "message":"Error encountered while setting primary user card in in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/UserCardController.php at 43 due to `Exception message`",
     *      "data":[]
     *  }
     */
    public function setDefaultPaymentCard(PaymentCardService $PaymentCardService, int $cardId): JsonResponse
    {
        // Set primary card
        $response = $PaymentCardService->setDefaultPaymentCard($cardId);

        // set api response
        $this->setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }

    /**
     * Delete a user card
     *
     * @param PaymentCardService $PaymentCardService
     * @param int $cardId
     * @return JsonResponse
     *
     * @group User Cards
     * @url /api/v2/user/user-cards/
     * @urlParam cardId numeric required User card id. Example: 1
     *
     * @response 200 {
     *      "message":"Successfully deleted user card",
     *      "data":{
                "id": 4,
                "user_id": 1,
                "payment_provider_id": 1,
                "third_party_card_id": "card_1HmB3HGOGj3Av1fnXW6jk75T",
                "card_last_four_digits": 4242
            }
     *  }
     *  @response 400 {
     *      "message":"Unable to delete primary card",
     *      "data":[]
     *  }
     * @response 512 {
     *      "message":"Error encountered while setting primary user card in in \/Bachelor\/Port\/Primary\/WebApi\/Controllers\/Api\/UserCardController.php at 43 due to `Exception message`",
     *      "data":[]
     *  }
     */
    public function delete(PaymentCardService $paymentCardService, int $cardId)
    {
        // Set primary card
        $response = $paymentCardService->deleteUserCard($cardId);

        // set api response
        $this->setResponse($response['status'], $response['message'], $response['data']);

        return ApiResponseHandler::jsonResponse($this->status, $this->message, $this->data);
    }
}
