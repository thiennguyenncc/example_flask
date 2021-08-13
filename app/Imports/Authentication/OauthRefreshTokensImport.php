<?php

namespace App\Imports\Authentication;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class OauthRefreshTokensImport implements ToModel, WithStartRow, WithHeadingRow
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
     * @return Model|Model[]|void|null
     */
    public function model(array $row)
    {
        try {
            \DB::table('oauth_refresh_tokens')->insert([
                'id' => $row['id'],
                'access_token_id' => $row['access_token_id'],
                'revoked' => $row['revoked'],
                'expires_at' => $row['expires_at']
            ]);
        } catch (\Exception $e) {
            Log::error('Migrate oauth refresh tokens data fail on id: ' . $row['id'] . 'with errors: ' . $e->getMessage());
        }
    }
}
