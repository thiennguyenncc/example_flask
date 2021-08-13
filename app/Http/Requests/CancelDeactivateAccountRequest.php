<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CancelDeactivateAccountRequest extends FormRequest
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
            'reason_about_date' => 'required|string|max:2000',
            'reason_about_date_other_text' => 'required|string|max:2000',
            'reason_about_date_i_not_prefer_other_text' => 'required|string|max:2000',
            'reason_about_service' => 'required|string|max:2000',
            'reason_about_service_other_text' => 'required|string|max:2000',
            'improvements_feedback' => 'required|string|max:2000',
            'other_opinion_feedback' => 'required|string|max:2000'
        ];
    }
}
