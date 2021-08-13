<?php

namespace App\Http\Requests\User\Plan;

use App\Http\Requests\JsonFormRequest;
use Bachelor\Domain\PaymentManagement\Plan\Enum\CostPlan;
use Bachelor\Domain\PaymentManagement\Plan\Enum\DiscountType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PlanRequest extends JsonFormRequest
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
            'discountType' => [
                'string',
                'nullable',
                Rule::in(DiscountType::getValues())
            ],
            'costPlan' => [
                'string',
                'nullable',
                Rule::in(CostPlan::getValues())
            ],
            'contractTerm' => [
                'numeric',
                'nullable'
            ],
        ];
    }
}
