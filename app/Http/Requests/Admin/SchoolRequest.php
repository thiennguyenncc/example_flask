<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\AdminRequest;
use Bachelor\Domain\MasterDataManagement\School\Enums\EducationGroup;
use Illuminate\Validation\Rule;

class SchoolRequest extends AdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'school_name' => ['string', 'max:191'],
            'education_group' => ['int', Rule::in(EducationGroup::getValues())],
            'is_selectable' => ['boolean'],
        ];
        if ($this->isMethod('post')) {
            $rules['school_name'][] = 'required';
            $rules['education_group'][] = 'required';
            $rules['is_selectable'][] = 'required';
        }
        return $rules;
    }
}
