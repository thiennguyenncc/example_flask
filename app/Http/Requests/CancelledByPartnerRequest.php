<?php

namespace App\Http\Requests;

use Bachelor\Domain\PaymentManagement\PaymentProvider\Enum\PaymentGateway;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CancelledByPartnerRequest extends JsonFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('api')->check();
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'datingId' => 'required|int',
            'requestRematching' => 'required|bool',
            'paymentGateway' => [
                'required',
                'string',
                Rule::in(PaymentGateway::getValues())
            ],
        ];
    }
}
