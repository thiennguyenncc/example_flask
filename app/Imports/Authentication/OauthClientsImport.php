<?php

namespace App\Imports\Authentication;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class OauthClientsImport implements ToModel, WithStartRow, WithHeadingRow
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
            \DB::table('oauth_clients')->insert([
                'id' => $row['id'],
                'user_id' => $row['user_id'],
                'name' => $row['name'],
                'secret' => $row['secret'],
                'provider' => null,
                'redirect' => $row['redirect'],
                'personal_access_client' => $row['personal_access_client'],
                'password_client' => $row['password_client'],
                'revoked' => $row['revoked'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            ]);
        } catch (\Exception $e) {
            Log::error('Migrate oauth access tokens data fail on id: ' . $row['id'] . 'with errors: ' . $e->getMessage());
        }
    }
}
