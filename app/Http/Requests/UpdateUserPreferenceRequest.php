<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPreferenceRequest extends FormRequest
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
            'ageFrom' => 'required|lte:ageTo',
            'ageTo' => 'required|gte:ageFrom',
            'heightTo' => 'required|lte:heightFrom',
            'heightFrom' => 'required|gte:heightTo',
            'partnerBodyMin' => 'required|lte:partnerBodyMax',
            'partnerBodyMax' => 'required|gte:partnerBodyMin',
            'smoking' => 'required',
            'drinking' => 'required',
            'divorce' => 'required',
            'annualIncome' => 'required',
            'education' => 'required',
            'job' => 'required',
            'facePreferences' => 'required',
            'appearancePriority' => 'required',
            'firstPriority' => 'required',
            'secondPriority' => 'required',
            'thirdPriority' => 'required',
            'hobby' => 'required'
        ];
    }
}
