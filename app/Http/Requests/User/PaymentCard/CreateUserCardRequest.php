<?php
namespace App\Http\Requests\User\PaymentCard;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
class CreateUserCardRequest extends FormRequest
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
        $rules = [
            'sourceToken' => 'required|string',
            'provider' => 'required|string',
        ];

        return $rules;
    }
}
