<?php

namespace App\Imports;

use Bachelor\Port\Secondary\Database\Base\Admin\ModelDao\Admin;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class AdminsImport implements ToModel, WithStartRow
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
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            return new Admin([
                'id' => $row[0],
                'name' => $row[1],
                'email' => $row[2],
                'password' => $row[3],
                'referred_by' => $row[4],
                'status' => $row[6],
                'ip_address' => $row[7],
                'last_login' => $row[8],
                'remember_token' => $row[9],
                'created_at' => $row[10],
                'updated_at' => $row[11]
            ]);
        } catch (\Exception $e) {
            Log::error('migrate admins data fail on id: ' . $row[0] . 'with errors: ' . $e->getMessage());
        }
    }
}
