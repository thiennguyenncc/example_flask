<?php

namespace App\Imports\Prefecture;

use Bachelor\Domain\MasterDataManagement\DatingPlace\Interfaces\DatingPlaceRepositoryInterface;
use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\ModelDao\DatingPlace;
use Bachelor\Port\Secondary\Database\MasterDataManagement\DatingPlace\ModelDao\DatingPlaceTranslation;
use Bachelor\Utility\Helpers\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DatingPlaceTranslationImport implements ToModel, WithStartRow, WithHeadingRow
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
                $datingPlaceTranslation = new DatingPlaceTranslation([
                    'id' => $row['id'],
                    'dating_place_id' => $row['location_id'],
                    'language_id' => $row['language_id'],
                    'name' => $row['name'],
                    'display_address' => $row['display_address'],
                    'zip_code' => $row['zipcode'] ?? '',
                    'created_at' => $row['created_at'],
                    'updated_at' => $row['updated_at']
                ]);
                $datingPlaceTranslation->save();
                $datingPlace = DatingPlace::where('id', $row['location_id'])->first();
                $datingPlace->reference_page_link = $row['yelp_url'];
                $datingPlace->save();
            }
        } catch (\Exception $e) {
            Log::error('Migrate dating place translation data fail on id: ' . $row['id'] . 'with errors: ' . $e->getMessage());
        }
    }
}
