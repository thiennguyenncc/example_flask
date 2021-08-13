<?php

namespace App\Http\Requests;

class AdminListUsersRequest extends AdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'search' => 'string|nullable',
            'gender' => 'integer',
            'status' => 'integer',
            'is_fake' => 'integer',
        ];
    }
}
