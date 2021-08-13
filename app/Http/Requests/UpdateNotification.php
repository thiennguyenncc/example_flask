<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotification extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//      return Auth::guard('admin')->check();
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'content' => 'nullable|string',
            'label' => 'nullable|string',
            'title' => 'nullable|string',
            'prefecture_ids' => 'nullable|array',
            'status' => 'nullable|integer',
        ];
    }
}
