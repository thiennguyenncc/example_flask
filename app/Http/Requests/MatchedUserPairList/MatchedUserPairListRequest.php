<?php

namespace App\Http\Requests\MatchedUserPairList;

use Illuminate\Foundation\Http\FormRequest;

class MatchedUserPairListRequest extends FormRequest
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
            'male' => 'required',
            'female' => 'required',
            'dating_place_id' => 'required',
            'area' => 'required',
            'dating_day_id' => 'required',
            'time' => 'required',
        ];
    }
}
