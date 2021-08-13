<?php

namespace App\Imports\Prefecture;

use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Bachelor\Port\Secondary\Database\UserManagement\UserPreferredArea\ModelDao\UserPreferredArea;
use Bachelor\Utility\Helpers\Log;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UserPreferredAreasImport implements ToModel, WithStartRow, WithHeadingRow
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
            $user = User::where('id', $row['user_id'])->first();
            if ($user) {
                $userPreferredArea = new UserPreferredArea([
                    'id' => $row['id'],
                    'user_id' => $row['user_id'],
                    'area_id' => $row['area_id'],
                    'priority' => $row['priority'],
                    'created_at' => $row['created_at'],
                    'updated_at' => $row['updated_at']
                ]);
                $userPreferredArea->save();
            }
        } catch (\Exception $e) {
            Log::error('Migrate user preferred areas data fail on id: ' . $row['id'] . 'with errors: ' . $e->getMessage());
        }
    }
}
