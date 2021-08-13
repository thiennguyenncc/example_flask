<?php

namespace Bachelor\Domain\MasterDataManagement\Area\Traits;

use Bachelor\Domain\Base\Language\Enums\Languages;
use Illuminate\Support\Facades\Auth;

trait AreaDataFormatterTrait
{
    /**
     *  Format data for creating new prefecture
     * @param array $params
     * @return array
     */
    protected function formatDataForArea(array $params): array
    {
        return [
            'area' => [
                'name' => $params['nameEn'],
                'admin_id' => Auth::user()?->id ?: 1,
                'prefecture_id' => $params['prefectureId']
            ],
            'areaTranslations' => [
                [
                    'name' => $params['nameEn'],
                    'language_id' => Languages::English()->toInt()
                ],
                [
                    'name' => $params['nameJa'],
                    'language_id' => Languages::Japanese()->toInt()
                ]
            ]
        ];
    }
}
