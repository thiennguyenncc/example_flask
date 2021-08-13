<?php

namespace App\Imports\Authentication;

use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\OauthAccessToken;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class OauthAccessTokensImport implements ToModel, WithStartRow, WithHeadingRow
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
            return new OauthAccessToken([
                'id' => $row['id'],
                'user_id' => $row['user_id'],
                'client_id' => $row['client_id'],
                'name' => $row['name'],
                'scopes' => $row['scopes'],
                'revoked' => $row['revoked'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at'],
                'expires_at' => $row['expires_at']
            ]);
        } catch (\Exception $e) {
            Log::error('Migrate oauth access tokens data fail on id: ' . $row['id'] . 'with errors: ' . $e->getMessage());
        }
    }
}
