<?php

namespace App\Http\Requests;

class AdminChangeUsersStatusRequest extends AdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => 'required|integer',
            'userIds' => 'required|array',
        ];
    }
}
