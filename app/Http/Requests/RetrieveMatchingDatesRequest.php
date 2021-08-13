<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;

class RetrieveMatchingDatesRequest extends JsonFormRequest
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
