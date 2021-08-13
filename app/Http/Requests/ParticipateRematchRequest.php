<?php

namespace App\Http\Requests;

class ParticipateRematchRequest extends UserFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'datingId' => 'required|int'
        ];
    }
}
