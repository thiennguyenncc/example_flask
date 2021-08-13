<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CodeVerificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mobileNumber' => 'required|string',
            'verificationCode' => 'required|int',
            'country' => 'required|string'
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'mobileNumber' => __('api_auth.mobile_number_required'),
            'verificationCode' => __('api_auth.mobile_number_required')
        ];
    }
}
