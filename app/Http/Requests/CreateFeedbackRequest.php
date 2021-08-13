<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateFeedbackRequest extends FormRequest
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
        return [
            'dating_id' => 'required',
            'last_satisfaction' => 'required|max:5|min:0',
            'face_points' => 'required|max:10|min:0',
            'personality_points' => 'required|max:10|min:0',
            'behaviour_points' => 'required|max:10|min:0',
            'face_complaint' => 'nullable|string',
            'face_good_factor' => 'nullable|string',
            'face_other_comment' => 'nullable|string|max:2000',
            'personality_complaint' => 'nullable|string',
            'personality_good_factor' => 'nullable|string',
            'personality_other_comment' => 'nullable|string|max:2000',
            'behaviour_complaint' => 'nullable|string',
            'behaviour_good_factor' => 'nullable|string',
            'behaviour_other_comment' => 'nullable|string|max:2000',
            'body_shape' => 'required|max:5|min:0',
            'the_better_point' => 'nullable|string',
            'the_worse_point' => 'nullable|string',
            'able_to_use_dating_place' => 'required_if:why_not_able_to_use_dating_place,<>,1|integer',
            'why_not_able_to_use_dating_place' => 'required_if:able_to_use_dating_place,<>,1|integer',
            'dating_place_any_complaint' => 'nullable|string|max:2000',
            'dating_place_review' => 'required|integer',
            'dating_place_review_comment' => 'nullable|string|max:2000',
            'flex1' => 'nullable|string|max:2000',
            'flex2' => 'nullable|string|max:2000',
            'b_suitable' => 'required',
            'calculateable_dating_report' => 'nullable|integer',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($validateFace = $this->requiredFaceField()) {
                if (isset($validateFace['key']) && $validateFace['key'] == 'complaint') {
                    $validator->errors()->add('face_complaint', 'Face complaint is required!');
                }
                if (isset($validateFace['key']) && $validateFace['key'] == 'good_factor') {
                    $validator->errors()->add('face_good_factor', 'Face good factor is required!');
                }
            }
            if ($this->requiredPersonalityFiled()) {
                if (isset($validateFace['key']) && $validateFace['key'] == 'complaint') {
                    $validator->errors()->add('personality_complaint', 'Personality complaint is required!');
                }
                if (isset($validateFace['key']) && $validateFace['key'] == 'good_factor') {
                    $validator->errors()->add('personality_good_factor', 'Personality good factor is required!');
                }
            }
            if ($this->requiredBehaviourField()) {
                if (isset($validateFace['key']) && $validateFace['key'] == 'complaint') {
                    $validator->errors()->add('behaviour_complaint', 'Behaviour complaint is required!');
                }
                if (isset($validateFace['key']) && $validateFace['key'] == 'good_factor') {
                    $validator->errors()->add('behaviour_good_factor', 'Behaviour good factor is required!');
                }
            }

        });
    }

    public function requiredFaceField(): array
    {
        $facePoints = $this->get('face_points');
        $faceOtherComment = $this->get('face_other_comment');
        $faceComplaint = $this->get('face_complaint');
        $faceGoodFactor = $this->get('face_good_factor');
        if ($facePoints >= 6) {
            if (! $faceOtherComment && ! $faceGoodFactor) {
                return [
                    'key' => 'good_factor'
                ];
            }
            return [];
        } else {
            if (! $faceOtherComment && ! $faceComplaint) {
                return [
                    'key' => 'complaint'
                ];
            }
            return [];
        }
    }

    public function requiredPersonalityFiled(): array
    {
        $personalityPoints = $this->get('personality_points');
        $personalityOtherComplaint = $this->get('personality_other_comment');
        $personalityComplaint = $this->get('personality_complaint');
        $personalityGoodFactor = $this->get('personality_good_factor');

        if ($personalityPoints >= 6) {
            if (! $personalityOtherComplaint && ! $personalityGoodFactor) {
                return [
                    'key' => 'good_factor'
                ];
            }
            return [];
        } else {
            if (! $personalityOtherComplaint && ! $personalityComplaint) {
                return [
                    'key' => 'complaint'
                ];
            }
            return [];
        }
    }

    public function requiredBehaviourField(): array
    {
        $behaviourPoints = $this->get('behaviour_points');
        $behaviourOtherComplaint = $this->get('behaviour_other_comment');
        $behaviourComplaint = $this->get('behaviour_complaint');
        $behaviourGoodFactor = $this->get('behaviour_good_factor');

        if ($behaviourPoints >= 6) {
            if (! $behaviourOtherComplaint && ! $behaviourGoodFactor) {
                return [
                    'key' => 'good_factor'
                ];
            }
            return [];
        } else {
            if (! $behaviourOtherComplaint && ! $behaviourComplaint) {
                return [
                    'key' => 'complaint'
                ];
            }
            return [];
        }
    }
}
