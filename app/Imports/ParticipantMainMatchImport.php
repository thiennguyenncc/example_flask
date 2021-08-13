<?php

namespace App\Imports;

use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantsStatus;
use Bachelor\Port\Secondary\Database\DatingManagement\DatingDay\ModelDao\DatingDay;
use Bachelor\Port\Secondary\Database\DatingManagement\ParticipantMainMatch\ModelDao\ParticipantMainMatch;
use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ParticipantMainMatchImport implements ToModel, WithStartRow
{
    private $isFirstTime;

    public function __construct($isFirstTime = false)
    {
        $this->isFirstTime = $isFirstTime;
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
            if (isset($row[4])) {
                $datingDateFormat = Carbon::parse($row[4])->toDateString();
                $datingDayData = DatingDay::where('dating_date', $datingDateFormat)->first();
                if ($datingDayData != null) {
                    if ($this->isFirstTime){
                        if ($row[3] == 1){
                            $this->saveData($row, $datingDayData);
                        }
                    }else{
                        $this->saveData($row, $datingDayData);
                    }
                    Log::info('ParticipantMainMatch of user '.$row[1].' on '. $row[4] . ' already exist');
                } else {
                    Log::info('dating day ' . $row[4] . ' does not exist');
                }
            }
        } catch (\Exception $e) {
            Log::info('error: ' . $e);
        }
    }

    private function saveData($row, $datingDayData){
        $participationExist = ParticipantMainMatch::where('user_id', $row[1])->where('dating_day_id', $datingDayData->id)->first();
        $user = User::where('id', $row[1])->first();
        if (! $participationExist && $user) {

            $participant = new ParticipantMainMatch([
                'user_id' => $row[1],
                'dating_day_id' => $datingDayData->id,
                'status' => ParticipantsStatus::Expired,
                'created_at' => $row[7],
                'updated_at' => $row[8],
            ]);
            $participant->save();
        }
    }
}
