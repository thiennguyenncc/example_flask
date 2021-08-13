<?php

namespace Bachelor\Domain\MasterDataManagement\Area\Enums;

use BenSampo\Enum\Enum;

/**
 *
 * @method static static Tokyo()
 * @method static static Kansai()
 */
final class Area extends Enum
{

    const Roppongi_Akasaka_Azabuzyuban = [
        'name' => 'Roppongi.Akasaka.Azabuzyuban',
        'prefectureId' => 1,
        'adminId' => 1,
        'nameEn' => 'Roppongi.Akasaka.Azabuzyuban',
        'nameJa' => '六本木・赤坂・麻布十番'
    ];

    const Shibuya_Harajuku_Ebisu = [
        'name' => 'Shibuya・Harajuku・Ebisu',
        'prefectureId' => 1,
        'adminId' => 1,
        'nameEn' => 'Shibuya・Harajuku・Ebisu',
        'nameJa' => '渋谷・原宿・恵比寿'
    ];

    const Ginza_Tokyo_Yurakucho = [
        'name' => 'Ginza.Tokyo.Yurakucho',
        'prefectureId' => 1,
        'adminId' => 1,
        'nameEn' => 'Ginza・Tokyo・Yurakucho',
        'nameJa' => '銀座・東京・有楽町'
    ];

    const Umeda = [
        'name' => 'Umeda area',
        'prefectureId' => 2,
        'adminId' => 1,
        'nameEn' => 'Umeda area',
        'nameJa' => '梅田エリア'
    ];

    const Nanba = [
        'name' => 'Nanba area',
        'prefectureId' => 2,
        'adminId' => 1,
        'nameEn' => 'Nanba area',
        'nameJa' => '難波エリア'
    ];
}
