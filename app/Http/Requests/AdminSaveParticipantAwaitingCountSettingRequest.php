<?php

namespace App\Http\Requests;

class AdminSaveParticipantAwaitingCountSettingRequest extends AdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'gender' => 'required|integer',
            'dating_date' => 'required|string',
            'prefecture_id' => 'required|integer',
            'settings' => 'array'
        ];
    }
}
