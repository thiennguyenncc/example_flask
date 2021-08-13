<?php

namespace App\Imports\Authentication;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class OauthPersonalAccessClientsImport implements ToModel, WithStartRow, WithHeadingRow
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
            \DB::table('oauth_personal_access_clients')->insert([
                'id' => $row['id'],
                'client_id' => $row['client_id'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            ]);
        } catch (\Exception $e) {
            Log::error('Migrate oauth personal access clients data fail on id: ' . $row['id'] . 'with errors: ' . $e->getMessage());
        }
    }
}
