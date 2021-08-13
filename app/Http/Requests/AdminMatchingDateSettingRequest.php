<?php

namespace App\Http\Requests;

class AdminMatchingDateSettingRequest extends AdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'userGender' => 'required|integer|min:1|max:2',
            'wednesdaySecondFormCompletedOpenDay' => 'required|integer|between:3,20',
            'wednesdaySecondFormCompletedExpireDay' => 'required|integer|between:0,19',
            'wednesdaySecondFormInCompletedOpenDay' => 'required|integer|between:3,20',
            'wednesdaySecondFormInCompletedExpireDay' => 'required|integer|between:0,19',
            'saturdaySecondFormCompletedOpenDay' => 'required|integer|between:3,20',
            'saturdaySecondFormCompletedExpireDay' => 'required|integer|between:0,19',
            'saturdaySecondFormInCompletedOpenDay' => 'required|integer|between:3,20',
            'saturdaySecondFormInCompletedExpireDay' => 'required|integer|between:0,19',
            'sundaySecondFormCompletedOpenDay' => 'required|integer|between:3,20',
            'sundaySecondFormCompletedExpireDay' => 'required|integer|between:0,19',
            'sundaySecondFormInCompletedOpenDay' => 'required|integer|between:3,20',
            'sundaySecondFormInCompletedExpireDay' => 'required|integer|between:0,19',
        ];
    }
}
