<?php

namespace App\Imports;

use Bachelor\Port\Secondary\Database\Communication\Chat\ModelDao\Room;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class RoomImport implements ToModel, WithStartRow
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
            return new Room([
                'id' => $row[0],
                'created_at' => $row[1],
                'updated_at' => $row[2],
                'name' => $row[3] ?? "Bachelor private room",
                'created_by' => $row[4],
                'type' => $row[5],
            ]);
        } catch (\Exception $e) {
            Log::error('migrate room data fail on id: ' . $row[0] . 'with errors: ' . $e->getMessage());
        }
    }
}
