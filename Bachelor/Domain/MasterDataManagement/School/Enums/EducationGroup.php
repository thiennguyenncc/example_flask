<?php

namespace Bachelor\Domain\MasterDataManagement\School\Enums;

use Bachelor\Utility\Enums\IntEnum;

/**
 * @method static Other()
 * @method static AssociateDiploma()
 * @method static LessFamousUniv()
 * @method static MediumStandardUniv()
 * @method static FamousUniv()
 * @method static MoreFamousFamousUniv()
 */
final class EducationGroup extends IntEnum
{
    const Other = 1;
    const AssociateDiploma = 2;
    const LessFamousUniv = 3;
    const MediumStandardUniv = 4;
    const FamousUniv = 5;
    const MoreFamousUniv = 6;

    // old system
    // 'HIGH_SCHOOL_DATABASE_VALUE' => 1,
    // 'ASSOCIATE_DIPLOMA' => 2,
    // 'LESS_FAMOUS_UNI_DATABASE_VALUE' => 3,
    // 'MEDIUM_STANDARD_UNI_DATABASE_VALUE' => 4,
    // 'FAMOUS_UNI_DATABASE_VALUE' => 5,
    // 'MORE_FAMOUS_UNI_DATABASE_VALUE' => 6,

    // 'MEDIUM_STANDARD_UNI' => [
    //     'SC000491',
    //     'SC000466',
    //     'SC000230',
    //     'SC000364',
    //     'SC000297',
    //     'SC000488',
    //     'SC000417',
    //     'SC000161',
    //     'SC000341',
    //     'SC000703',
    //     'SC003131',
    //     'SC000131',
    //     'SC000333',
    //     'SC000332',
    //     'SC000480',
    //     'SC000512',
    //     'SC000376',
    //     'SC000218',
    //     'SC000573',
    //     'SC000554'
    // ],
    // 'FAMOUS UNI' => [
    //     'SC004737',
    //     'SC000305',
    //     'SC000453',
    //     'SC000555',
    //     'SC000351',
    //     'SC000560',
    //     'SC000406',
    //     'SC000191',
    //     'SC000192',
    //     'SC000472',
    //     'SC000562',
    //     'SC000528',
    //     'SC000258',
    //     'SC000186',
    // ],
    // 'MORE_FAMOUS UNI' => [
    //     'SC000073',
    //     'SC000017',
    //     'SC000371',
    //     'SC000235',
    //     'SC000005',
    //     'SC000070',
    //     'SC000056'
    // ]
}
