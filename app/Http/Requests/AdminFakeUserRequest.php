<?php

namespace App\Http\Requests;

class AdminFakeUserRequest extends AdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'userId' => 'required|integer',
            'fake' => 'required|boolean',
        ];
    }
}
