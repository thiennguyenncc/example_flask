<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateNotification extends FormRequest
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
            'key' => 'required|string',
            'group_key' => 'required|string',
            'cronjob_key' => 'required|string',
            'label' => 'required|string',
            'title' => 'required|string',
            'message' => 'required|string',
            'prefectures' => 'required|string',
            'status' => 'required|string',
            'variables' => 'required|string',
        ];
    }
}
