<?php

namespace App\Http\Requests;

use Bachelor\Domain\UserManagement\User\Enums\EducationType;
use Bachelor\Domain\UserManagement\UserProfile\Enums\AnnualIncome;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rule = [
            'birthday' => 'required',
            'height' => 'required',
            'bodyType' => 'required',
            'marriageIntention' => 'required',
            'character' => 'required',
            'smoking' => 'required',
            'drinking' => 'required',
            'divorce' => 'required',
            'annualIncome' => 'required',
            'appearanceStrength' => 'required',
            'companyName' => 'required',
            'job' => 'required',
            'hobby' => 'required'
        ];
        if ($this->request->get('annualIncome') === AnnualIncome::ThreeToFour){
            $rule = array_merge($rule, ['education' => 'required']);
        }
        if (array_key_exists('education', $rule) && $this->request->get('education') <= EducationType::AssociateOrDiploma){
            $rule = array_merge($rule, [
                'schoolId' => 'required',
            ]);
        }
        return $rule;
    }
}
