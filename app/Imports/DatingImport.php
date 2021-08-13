<?php

namespace App\Imports;

use Bachelor\Port\Secondary\Database\DatingManagement\Dating\ModelDao\Dating;
use Bachelor\Port\Secondary\Database\DatingManagement\DatingDay\ModelDao\DatingDay;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DatingImport implements ToModel, WithStartRow
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
            if (isset($row[2])) {
                $datingDateFormat = Carbon::parse($row[2])->toDateString();
                $datingDayData = DatingDay::where('dating_date', $datingDateFormat)->first();
                if ($datingDayData != null) {
                    $datingExist = Dating::find($row[0]);
                    if ($datingExist == null) {
                        return new Dating([
                            'id' => $row[0],
                            'dating_day_id' => $datingDayData->id,
                            'start_at' => $row[2],
                            'dating_place_id' => $row[8],
                            'status' => $row[1],
                            'created_at' => $row[10],
                            'updated_at' => $row[11],
                        ]);
                    }
                    Log::info('dating id '.$row[0].' already exist');
                } else {
                    Log::info('dating day ' . $row[2] . ' does not exist');
                }
            }
        } catch (\Exception $e) {
            Log::info('import dating error: ' . $e);
        }
    }
}
