<?php

namespace App\Imports;

use Bachelor\Domain\DatingManagement\Dating\Enums\DatingStatus;
use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\DatingUser;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DatingUserImPort implements ToModel, WithStartRow
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
            $datingUserExist = DatingUser::find($row[0]);
            $user = User::where('id', $row[1])->first();
            if (!$datingUserExist && $user) {
                return new DatingUser([
                    'id' => $row[0],
                    'dating_id' => $row[4],
                    'user_id' => $row[1],
                    'cancelled_at' => str_replace("'", "", $row[5]) == DatingStatus::Cancelled ? $row[7] : null,
                    'created_at' => $row[10],
                    'updated_at' => $row[11]
                ]);
            }
        } catch (\Exception $e) {
            Log::info('import dating user error: ' . $e);
        }
    }
}
