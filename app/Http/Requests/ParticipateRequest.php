<?php

namespace App\Http\Requests;

class ParticipateRequest extends UserFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'requestDateIds' => 'array|nullable',
            'cancelDateIds' => 'array|nullable',
        ];
    }
}
