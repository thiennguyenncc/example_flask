<?php

namespace Bachelor\Domain\MasterDataManagement\Prefecture\Enums;

use Bachelor\Utility\Enums\Status;
use BenSampo\Enum\Enum;

/**
 * @method static static Tokyo()
 * @method static static Kansai()
 * @method static static Yokohama()
 * @method static static Nagoya()
 * @method static static Fukuoka()
 */
final class Prefecture extends Enum
{
    const Tokyo = [
        'name' => 'Tokyo',
        'country' => 1,
        'admin' => 1,
        'status' => Status::Active,
        'ip_address' => '127.0.0.1',
        'prefecture_translations' => [
            'Tokyo',
            '東京'
        ]
    ];
    const Kansai = [
        'name' => 'Kansai',
        'country' => 1,
        'admin' => 1,
        'status' => Status::Active,
        'ip_address' => '127.0.0.1',
        'prefecture_translations' => [
            'Kansai',
            '関西'
        ]
    ];
    const Yokohama  = [
        'name' => 'Yokohama (Coming soon!)',
        'country' => 1,
        'admin' => 1,
        'status' => Status::Inactive,
        'ip_address' => '127.0.0.1',
        'prefecture_translations' => [
            'Yokohama (Coming soon!)',
            '横浜（準備中！）'
        ]
    ];

    const Nagoya = [
        'name' => 'Nagoya (Coming soon!)',
        'country' => 1,
        'admin' => 1,
        'country_id' => 1,
        'status' => Status::Inactive,
        'ip_address' => '127.0.0.1',
        'prefecture_translations' => [
            'Nagoya (Coming soon!)',
            '名古屋（準備中！)'
        ]
    ];

    const Fukuoka = [
        'name' => 'Fukuoka (Coming soon!)',
        'country' => 1,
        'admin' => 1,
        'status' => Status::Inactive,
        'ip_address' => '127.0.0.1',
        'prefecture_translations' => [
            'Fukuoka (Coming soon!)',
            '福岡（準備中！）'
        ]
    ];
}
