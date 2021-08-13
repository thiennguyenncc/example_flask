<?php

namespace App\Imports;

use Bachelor\Port\Secondary\Database\DatingManagement\DatingDay\ModelDao\DatingDay;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DatingDayImport implements ToModel, WithStartRow
{
    private $index;

    public function __construct(int $index = 4)
    {
        $this->index = $index;
    }
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
            if (isset($row[$this->index])){
                $datingDate = Carbon::parse($row[$this->index]);
                $datingDateFormat = Carbon::parse($row[$this->index])->toDateString();
                $datingDayFormat = $datingDate->format('l');
                $datingDayExist = DatingDay::where('dating_date', $datingDateFormat)->first();
                if ($datingDayExist == null){
                    return new DatingDay([
                        'dating_day' => $datingDayFormat,
                        'dating_date' => $datingDateFormat,
                    ]);
                }else{
                    Log::info('dating day '.$row[$this->index].' already exist');
                }
            }
        }catch (\Exception $e){
            Log::info('error: '.$e);
        }
    }
}
