<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class GetDatingPlaceRequest extends AdminRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'category' => 'string',
            'area_id' => 'integer',
            'status' => 'integer'
        ];
    }
}
