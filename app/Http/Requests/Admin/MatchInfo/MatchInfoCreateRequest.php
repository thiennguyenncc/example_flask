<?php
namespace App\Http\Requests\Admin\MatchInfo;

use App\Http\Requests\AdminRequest;

class MatchInfoCreateRequest extends AdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'info_params_list.*.description' => ['string','max:191','required'],
            'info_params_list.*.image' => ['image','mimes:jpeg,png,jpg,gif','max:10240','required'],
        ];
        return $rules;
    }
}
