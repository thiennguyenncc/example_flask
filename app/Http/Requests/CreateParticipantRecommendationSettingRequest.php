<?php

namespace App\Http\Requests;

class CreateParticipantRecommendationSettingRequest extends AdminRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'dateId' => 'required|integer',
            'gender' => 'required|integer',
            'ratio.*.daysBefore' => 'required|integer',
            'ratio.*.ratio' => 'required|numeric',
        ];
    }
}
