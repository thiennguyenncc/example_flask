<?php

namespace App\Http\Requests;

class AdminRematchingRequest extends AdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rematching_file' => 'required|max:51200',
        ];
    }
}
