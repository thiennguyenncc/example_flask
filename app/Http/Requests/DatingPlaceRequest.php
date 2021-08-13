<?php

namespace App\Http\Requests;

use Bachelor\Domain\DatingManagement\DatingDay\Enums\DatingDayOfWeek;

class DatingPlaceRequest extends AdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'areaId' => 'required|integer',
            'trainStationId' => 'required|integer',
            'category' => 'required|string|max:191',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'rating' => 'required|numeric',
            'displayPhone' => 'required|string|max:191',
            'phone' => 'required|string|max:191',
            'nameEn' => 'required|string',
            'nameJa' => 'required|string',
            'displayAddress' => 'required|string',
            'zipCode' => 'nullable|string',
            'country' => 'nullable|string',
            'datingPlaceImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'referencePageLink' => 'string|max:191',
        ];

        foreach (DatingDayOfWeek::getValues() as $dayOfWeek) {
            $rules[$dayOfWeek] = 'array|required';
            $rules[$dayOfWeek . '.openAt'] = 'required|date_format:H:i';
            $rules[$dayOfWeek . '.closeAt'] = 'required|date_format:H:i';
        }

        return $rules;
    }
}
