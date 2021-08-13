<?php

namespace App\Imports\Prefecture;

use Bachelor\Domain\MasterDataManagement\DatingPlace\Interfaces\DatingPlaceRepositoryInterface;
use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\ModelDao\DatingPlace;
use Bachelor\Port\Secondary\Database\MasterDataManagement\TrainStation\ModelDao\TrainStation;
use Bachelor\Utility\Helpers\Log;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TrainStationImport implements ToModel, WithStartRow, WithHeadingRow
{
    protected DatingPlaceRepositoryInterface $datingPlaceRepository;

    public function __construct()
    {
        $this->datingPlaceRepository = app()->make(DatingPlaceRepositoryInterface::class);
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
     * @return Model|null
     */
    public function model(array $row)
    {
        try {
            $datingPlace = DatingPlace::where('id', $row['location_id'])->first();
            if ($datingPlace) {
                $datingPlace->train_station_id = $row['id'];
                $datingPlace->save();
            }
            return new TrainStation([
                'id' => $row['id'],
                'google_train_station_id' => $row['google_train_station_id'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            ]);
        } catch (\Exception $e) {
            Log::error('Migrate train station data fail on id: ' . $row['id'] . 'with errors: ' . $e->getMessage());
        }
    }
}
