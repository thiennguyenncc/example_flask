<?php

namespace App\Http\Requests;

class CancelRematchRequest extends UserFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'datingDayIds' => 'required|array'
        ];
    }
}
