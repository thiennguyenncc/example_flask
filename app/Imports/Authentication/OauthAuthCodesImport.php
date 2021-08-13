<?php

namespace App\Imports\Authentication;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class OauthAuthCodesImport implements ToModel, WithStartRow, WithHeadingRow
{
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param array $row
     *
     * @return Model|null
     */
    public function model(array $row)
    {
        try {
            \DB::table('oauth_auth_codes')->insert([
                'id' => $row['id'],
                'user_id' => $row['user_id'],
                'client_id' => $row['client_id'],
                'scopes' => $row['scopes'],
                'revoked' => $row['revoked'],
                'expires_at' => $row['expires_at']
            ]);
        } catch (\Exception $e) {
            Log::error('Migrate oauth auth codes data fail on id: ' . $row['id'] . 'with errors: ' . $e->getMessage());
        }
    }
}
