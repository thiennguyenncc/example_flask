<?php

namespace App\Imports;

use Bachelor\Port\Secondary\Database\Communication\Chat\ModelDao\Message;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MessageImport implements ToModel, WithStartRow
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
            return new Message([
                'id' => $row[0],
                'user_id' => $row[1],
                'receiver_id' => $row[2],
                'room_id' => $row[3],
                'content' => $row[4],
                'unread' => $row[5],
                'type' => $row[8],
                'sid' => $row[9],
                'index' => $row[10],
                'created_at' => $row[6],
                'updated_at' => $row[7],
            ]);
        }catch (\Exception $e){
            Log::error('migrate messages data fail on id: '.$row[0].'with errors: '.$e->getMessage());
        }
    }
}
