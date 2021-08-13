<?php

namespace App\Imports;

use Bachelor\Port\Secondary\Database\Communication\Chat\ModelDao\RoomUser;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class RoomUserImport implements ToModel, WithStartRow
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
            return new RoomUser([
                'id' => $row[0],
                'user_id' => $row[1],
                'room_id' => $row[2],
                'created_at' => $row[3],
                'updated_at' => $row[4],
                'type' => $row[5],
            ]);
        } catch (\Exception $e) {
            Log::error('migrate room user data fail on id: ' . $row[0] . 'with errors: ' . $e->getMessage());
        }
    }
}
