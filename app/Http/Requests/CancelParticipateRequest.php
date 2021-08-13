<?php

namespace App\Http\Requests;

class CancelParticipateRequest extends UserFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'dateIds' => 'required|array'
        ];
    }
}
