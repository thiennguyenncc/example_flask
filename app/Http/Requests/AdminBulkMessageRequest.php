<?php

namespace App\Http\Requests;

class AdminBulkMessageRequest extends AdminRequest
{
    /**
     * Get the validation rules that apply to the request.bachelor@localhost
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'required|max:51200'
        ];
    }
}
