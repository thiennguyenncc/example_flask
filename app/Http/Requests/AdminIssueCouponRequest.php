<?php

namespace App\Http\Requests;

class AdminIssueCouponRequest extends AdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'userId' => 'required|integer',
            'couponTypes' => 'required|array',
        ];
    }
}
