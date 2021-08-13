<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Bachelor\Domain\DatingManagement\RequestCancellationForm\Enums\ReasonForCancellation;
use Bachelor\Domain\PaymentManagement\PaymentProvider\Enum\PaymentGateway;

class CancelDatingRequest extends JsonFormRequest
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
            'reasonForCancellation' => 'required|array',
            'reasonForCancellation.*' => [
                'int',
                Rule::in(ReasonForCancellation::getValues())
            ],
            'reasonForCancellationOtherText' => 'nullable|string',
            'reasonForCancellationDissatisfactionOtherText' => 'nullable|string',
            'detailedReason' => 'required|string',
            'datingId' => 'required|int',
            'paymentGateway' => [
                'required',
                'string',
                Rule::in(PaymentGateway::getValues())
            ],
        ];
    }
}
