<?php
namespace App\Http\Requests\Admin\MatchInfo;

use App\Http\Requests\AdminRequest;

class MatchInfoUpdateRequest extends AdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'description' => ['string','max:191'],
            'image' => ['image','mimes:jpeg,png,jpg,gif','max:10240'],
        ];
        return $rules;
    }
}
