<?php

namespace App\Http\Requests;

class AdminSearchNotificationsRequest extends AdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'string|required',
            'search' => 'string|nullable',
        ];
    }
}
