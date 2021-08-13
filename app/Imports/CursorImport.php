<?php

namespace App\Imports;

use Bachelor\Port\Secondary\Database\Communication\Chat\ModelDao\Cursor;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CursorImport implements ToModel, WithStartRow
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
            return new Cursor([
                'id' => $row[0],
                'room_id' => $row[1],
                'user_id' => $row[2],
                'message_id' => $row[3],
                'created_at' => $row[4],
                'updated_at' => $row[5],
                'type' => $row[6],
                'message_index' => $row[7],
            ]);
        } catch (\Exception $e) {
            Log::error('migrate cursor data fail on id: ' . $row[0] . 'with errors: ' . $e->getMessage());
        }
    }
}
