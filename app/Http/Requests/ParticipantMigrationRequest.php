<?php

namespace App\Http\Requests;

class ParticipantMigrationRequest extends AdminRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'migration_file' => 'required|max:51200',
        ];
    }
}
