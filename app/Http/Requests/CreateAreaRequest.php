<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateAreaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //        return Auth::guard('admin')->check();
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
            'nameEn' => 'unique:prefectures,name|required|string|max:9',
            'nameJa' => 'unique:prefecture_translations,name|required|string|max:4',
            'prefectureId' => 'required|integer'
        ];
    }
}
