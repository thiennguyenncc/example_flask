<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class UserFormRequest extends JsonFormRequest
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
}
