<?php


namespace App\Http\Requests;


class TrainStationRequest extends AdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'id' => 'number',
            'google_train_station_id' => 'string|max:191',
            'station_name' => 'string|max:191',
        ];
        return $rules;
    }
}
