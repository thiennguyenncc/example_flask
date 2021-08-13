<?php

namespace App\Http\Requests;

class AreaRequest extends AdminRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string',
            'prefecture_id' => 'integer',
            'status' => 'integer'
        ];
    }
}
