<?php

namespace Database\Seeders;

use Bachelor\Domain\MasterDataManagement\School\Enums\EducationGroup;
use Bachelor\Domain\MasterDataManagement\School\Interfaces\SchoolRepositoryInterface;
use Bachelor\Utility\Helpers\Log;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    private SchoolRepositoryInterface $schoolRepository;

    public function __construct(SchoolRepositoryInterface $schoolRepositoryInterface)
    {
        $this->schoolRepository = $schoolRepositoryInterface;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time_start = microtime(true);
        echo 'SchoolSeeder started' . PHP_EOL;
        $this->_seed();
        $time_end = microtime(true);
        Log::info('SchoolSeeder finished | took ' . ($time_end - $time_start) . 's' . PHP_EOL);
    }

    private function _seed()
    {
        $seeds = $this->_getSeeds();
        foreach ($seeds as $data) {
            $this->schoolRepository->firstOrCreate($data);
        }
    }

    private function _getSeeds(): array
    {
        return [
            0 => [
                'school_name' => 'その他',
                'education_group' => EducationGroup::Other,
            ],
            1 => [
                'school_name' => 'スポーツ/健康系専門・短大',
                'education_group' => EducationGroup::AssociateDiploma,
            ],
            2 => [
                'school_name' => 'その他専門・短大',
                'education_group' => EducationGroup::AssociateDiploma,
            ],
            3 => [
                'school_name' => '医療/看護/福祉専門・短大',
                'education_group' => EducationGroup::AssociateDiploma,
            ],
            4 => [
                'school_name' => '機械/電気/電子/科学専門・短大',
                'education_group' => EducationGroup::AssociateDiploma,
            ],
            5 => [
                'school_name' => '金融/ビジネス/IT系専門・短大',
                'education_group' => EducationGroup::AssociateDiploma,
            ],
            6 => [
                'school_name' => '芸能/エンタメ/文化系専門・短大',
                'education_group' => EducationGroup::AssociateDiploma,
            ],
            7 => [
                'school_name' => '国際/語学系専門・短大',
                'education_group' => EducationGroup::AssociateDiploma,
            ],
            8 => [
                'school_name' => '調理/製菓/栄養専門・短大',
                'education_group' => EducationGroup::AssociateDiploma,
            ],
            9 => [
                'school_name' => '美容/ファッション系専門・短大',
                'education_group' => EducationGroup::AssociateDiploma,
            ],
            10 => [
                'school_name' => '保育/教育系専門・短大',
                'education_group' => EducationGroup::AssociateDiploma,
            ],
            11 => [
                'school_name' => '旅行/ホテル/ブライダル系専門・短大',
                'education_group' => EducationGroup::AssociateDiploma,
            ],
            12 => [
                'school_name' => 'LEC東京リーガルマインド大学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            13 => [
                'school_name' => 'エリザベト音楽大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            14 => [
                'school_name' => 'くらしき作陽大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            15 => [
                'school_name' => 'こども教育宝仙大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            16 => [
                'school_name' => 'サイバー大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            17 => [
                'school_name' => 'つくば国際大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            18 => [
                'school_name' => 'デジタルハリウッド大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            19 => [
                'school_name' => 'テンプル大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            20 => [
                'school_name' => 'ノートルダム清心女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            21 => [
                'school_name' => 'ビジネス・ブレークスルー大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            22 => [
                'school_name' => 'びわこ成蹊スポーツ大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            23 => [
                'school_name' => 'プール学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            24 => [
                'school_name' => 'フリーバード',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            25 => [
                'school_name' => 'ものつくり大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            26 => [
                'school_name' => 'ヤマザキ動物看護大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            27 => [
                'school_name' => '亜細亜大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            28 => [
                'school_name' => '愛知学泉大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            29 => [
                'school_name' => '愛知県立芸術大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            30 => [
                'school_name' => '愛知県立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            31 => [
                'school_name' => '愛知県立農業大学校',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            32 => [
                'school_name' => '愛知工科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            33 => [
                'school_name' => '愛知産業大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            34 => [
                'school_name' => '愛知淑徳大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            35 => [
                'school_name' => '愛知大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            36 => [
                'school_name' => '愛知東邦大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            37 => [
                'school_name' => '愛媛県立医療技術大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            38 => [
                'school_name' => '愛媛大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            39 => [
                'school_name' => '芦屋大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            40 => [
                'school_name' => '安田女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            41 => [
                'school_name' => '杏林大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            42 => [
                'school_name' => '医療創生大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            43 => [
                'school_name' => '一宮研伸大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            44 => [
                'school_name' => '茨城キリスト教大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            45 => [
                'school_name' => '茨城県立医療大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            46 => [
                'school_name' => '宇部フロンティア大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            47 => [
                'school_name' => '羽衣国際大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            48 => [
                'school_name' => '浦和大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            49 => [
                'school_name' => '園田学園女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            50 => [
                'school_name' => '奥羽大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            51 => [
                'school_name' => '横浜桐蔭大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            52 => [
                'school_name' => '横浜商科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            53 => [
                'school_name' => '横浜創英大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            54 => [
                'school_name' => '横浜美術大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            55 => [
                'school_name' => '横浜薬科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            56 => [
                'school_name' => '岡崎女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            57 => [
                'school_name' => '岡山県立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            58 => [
                'school_name' => '岡山商科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            59 => [
                'school_name' => '岡山理科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            60 => [
                'school_name' => '沖縄県立看護大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            61 => [
                'school_name' => '沖縄国際大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            62 => [
                'school_name' => '嘉悦大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            63 => [
                'school_name' => '花園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            64 => [
                'school_name' => '会津大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            65 => [
                'school_name' => '活水女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            66 => [
                'school_name' => '鎌倉女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            67 => [
                'school_name' => '環太平洋大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            68 => [
                'school_name' => '関西医療大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            69 => [
                'school_name' => '関西外国語大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            70 => [
                'school_name' => '関西看護医療大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            71 => [
                'school_name' => '関西国際大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            72 => [
                'school_name' => '関西福祉科学大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            73 => [
                'school_name' => '関西福祉大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            74 => [
                'school_name' => '関東学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            75 => [
                'school_name' => '関東学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            76 => [
                'school_name' => '岩手県立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            77 => [
                'school_name' => '岐阜医療科学大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            78 => [
                'school_name' => '岐阜協立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            79 => [
                'school_name' => '岐阜県立看護大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            80 => [
                'school_name' => '岐阜歯科',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            81 => [
                'school_name' => '岐阜女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            82 => [
                'school_name' => '岐阜聖徳学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            83 => [
                'school_name' => '岐阜保健大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            84 => [
                'school_name' => '畿央大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            85 => [
                'school_name' => '吉備国際大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            86 => [
                'school_name' => '久留米工業大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            87 => [
                'school_name' => '久留米大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            88 => [
                'school_name' => '宮崎県立看護大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            89 => [
                'school_name' => '宮崎公立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            90 => [
                'school_name' => '宮崎大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            91 => [
                'school_name' => '宮城学院女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            92 => [
                'school_name' => '宮城大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            93 => [
                'school_name' => '京都ノートルダム女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            94 => [
                'school_name' => '京都外国語大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            95 => [
                'school_name' => '京都学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            96 => [
                'school_name' => '京都橘大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            97 => [
                'school_name' => '京都芸術大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            98 => [
                'school_name' => '京都建築大学校',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            99 => [
                'school_name' => '京都光華女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            100 => [
                'school_name' => '京都女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            101 => [
                'school_name' => '京都精華大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            102 => [
                'school_name' => '京都先端科学大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            103 => [
                'school_name' => '京都造形芸術大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            104 => [
                'school_name' => '京都文教大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            105 => [
                'school_name' => '共愛学園前橋国際大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            106 => [
                'school_name' => '共栄大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            107 => [
                'school_name' => '共立女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            108 => [
                'school_name' => '玉川大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            109 => [
                'school_name' => '桐蔭横浜大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            110 => [
                'school_name' => '桐生大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            111 => [
                'school_name' => '金城学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            112 => [
                'school_name' => '金城大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            113 => [
                'school_name' => '金沢学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            114 => [
                'school_name' => '金沢工業大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            115 => [
                'school_name' => '九州ルーテル学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            116 => [
                'school_name' => '九州栄養福祉大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            117 => [
                'school_name' => '九州看護福祉大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            118 => [
                'school_name' => '九州共立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            119 => [
                'school_name' => '九州国際大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            120 => [
                'school_name' => '九州産業大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            121 => [
                'school_name' => '九州歯科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            122 => [
                'school_name' => '九州女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            123 => [
                'school_name' => '九州情報大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            124 => [
                'school_name' => '九州保健福祉大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            125 => [
                'school_name' => '駒沢女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            126 => [
                'school_name' => '釧路公立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            127 => [
                'school_name' => '熊本学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            128 => [
                'school_name' => '熊本県立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            129 => [
                'school_name' => '熊本保健科学大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            130 => [
                'school_name' => '群馬パース大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            131 => [
                'school_name' => '群馬医療福祉大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            132 => [
                'school_name' => '群馬県立県民健康科学大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            133 => [
                'school_name' => '郡山女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            134 => [
                'school_name' => '恵泉女学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            135 => [
                'school_name' => '敬愛大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            136 => [
                'school_name' => '健康科学大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            137 => [
                'school_name' => '県立広島大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            138 => [
                'school_name' => 'はこだて未来大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            139 => [
                'school_name' => '千歳科学技術大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            140 => [
                'school_name' => '広島経済大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            141 => [
                'school_name' => '広島工業大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            142 => [
                'school_name' => '広島国際大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            143 => [
                'school_name' => '広島市立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            144 => [
                'school_name' => '広島修道大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            145 => [
                'school_name' => '広島女学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            146 => [
                'school_name' => '広島文化学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            147 => [
                'school_name' => '広島文教大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            148 => [
                'school_name' => '弘前学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            149 => [
                'school_name' => '江戸川大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            150 => [
                'school_name' => '甲子園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            151 => [
                'school_name' => '甲南女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            152 => [
                'school_name' => '皇學館大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            153 => [
                'school_name' => '香川県立保健医療大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            154 => [
                'school_name' => '高崎健康福祉大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            155 => [
                'school_name' => '高千穂大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            156 => [
                'school_name' => '高知県立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            157 => [
                'school_name' => '高知工科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            158 => [
                'school_name' => '高知大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            159 => [
                'school_name' => '国際医療福祉大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            160 => [
                'school_name' => '国際大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            161 => [
                'school_name' => '国際武道大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            162 => [
                'school_name' => '国立看護大学校',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            163 => [
                'school_name' => '佐賀大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            164 => [
                'school_name' => '佐久大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            165 => [
                'school_name' => '嵯峨美術大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            166 => [
                'school_name' => '阪南大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            167 => [
                'school_name' => '埼玉県立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            168 => [
                'school_name' => '埼玉工業大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            169 => [
                'school_name' => '作新学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            170 => [
                'school_name' => '桜花学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            171 => [
                'school_name' => '桜花大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            172 => [
                'school_name' => '桜美林大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            173 => [
                'school_name' => '札幌学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            174 => [
                'school_name' => '札幌国際大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            175 => [
                'school_name' => '札幌市立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            176 => [
                'school_name' => '札幌大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            177 => [
                'school_name' => '三育学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            178 => [
                'school_name' => '三重県立看護大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            179 => [
                'school_name' => '三重中京大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            180 => [
                'school_name' => '三条市立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            181 => [
                'school_name' => '山形県立保健医療大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            182 => [
                'school_name' => '山形大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            183 => [
                'school_name' => '山口学芸大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            184 => [
                'school_name' => '山口県立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            185 => [
                'school_name' => '山口大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            186 => [
                'school_name' => '山陽学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            187 => [
                'school_name' => '山口東京理科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            188 => [
                'school_name' => '山梨英和',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            189 => [
                'school_name' => '山梨学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            190 => [
                'school_name' => '山梨県立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            191 => [
                'school_name' => '四国学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            192 => [
                'school_name' => '四国大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            193 => [
                'school_name' => '四天王寺大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            194 => [
                'school_name' => '四日市看護医療大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            195 => [
                'school_name' => '四條畷学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            196 => [
                'school_name' => '志學館大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            197 => [
                'school_name' => '至学館大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            198 => [
                'school_name' => '至誠館大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            199 => [
                'school_name' => '滋賀県立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            200 => [
                'school_name' => '鹿屋体育大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            201 => [
                'school_name' => '鹿児島純心女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            202 => [
                'school_name' => '室蘭工業大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            203 => [
                'school_name' => '実践女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            204 => [
                'school_name' => '柴田学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            205 => [
                'school_name' => '種智院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            206 => [
                'school_name' => '就実大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            207 => [
                'school_name' => '修文大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            208 => [
                'school_name' => '秀明大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            209 => [
                'school_name' => '秋田看護福祉大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            210 => [
                'school_name' => '秋田県立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            211 => [
                'school_name' => '秋田公立美術大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            212 => [
                'school_name' => '十文字学園女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            213 => [
                'school_name' => '淑徳大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            214 => [
                'school_name' => '駿河台大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            215 => [
                'school_name' => '純真学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            216 => [
                'school_name' => '女子栄養大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            217 => [
                'school_name' => '女子美術大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            218 => [
                'school_name' => '尚美学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            219 => [
                'school_name' => '尚絅学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            220 => [
                'school_name' => '松蔭大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            221 => [
                'school_name' => '松山大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            222 => [
                'school_name' => '松山東雲女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            223 => [
                'school_name' => '松本大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            224 => [
                'school_name' => '湘南工科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            225 => [
                'school_name' => '上武大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            226 => [
                'school_name' => '上野学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            227 => [
                'school_name' => '城西国際大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            228 => [
                'school_name' => '城西大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            229 => [
                'school_name' => '常磐会学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            230 => [
                'school_name' => '常磐大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            231 => [
                'school_name' => '常葉大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            232 => [
                'school_name' => '職業能力開発総合大学校',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            233 => [
                'school_name' => '新潟医療福祉大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            234 => [
                'school_name' => '新潟経営大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            235 => [
                'school_name' => '新潟県立看護大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            236 => [
                'school_name' => '新潟工科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            237 => [
                'school_name' => '新潟青陵大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            238 => [
                'school_name' => '新潟薬科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            239 => [
                'school_name' => '森ノ宮医療大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            240 => [
                'school_name' => '神戸医療福祉大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            241 => [
                'school_name' => '神戸海星女子学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            242 => [
                'school_name' => '神戸学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            243 => [
                'school_name' => '神戸芸術工科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            244 => [
                'school_name' => '神戸国際大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            245 => [
                'school_name' => '神戸市看護大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            246 => [
                'school_name' => '神戸女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            247 => [
                'school_name' => '神戸商科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            248 => [
                'school_name' => '神戸松蔭女子学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            249 => [
                'school_name' => '神戸常盤大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            250 => [
                'school_name' => '神戸親和女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            251 => [
                'school_name' => '神田外語大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            252 => [
                'school_name' => '神奈川県立保健福祉大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            253 => [
                'school_name' => '神奈川工科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            254 => [
                'school_name' => '神奈川歯科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            255 => [
                'school_name' => '神奈川大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            256 => [
                'school_name' => '人間環境大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            257 => [
                'school_name' => '人間総合科学大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            258 => [
                'school_name' => '仁愛大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            259 => [
                'school_name' => '水産大学校',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            260 => [
                'school_name' => '崇城大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            261 => [
                'school_name' => '杉山女学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            262 => [
                'school_name' => '杉野服飾大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            263 => [
                'school_name' => '椙山女学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            264 => [
                'school_name' => '成安造形大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            265 => [
                'school_name' => '星城大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            266 => [
                'school_name' => '星槎大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            267 => [
                'school_name' => '星槎道都大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            268 => [
                'school_name' => '清泉女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            269 => [
                'school_name' => '清和大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            270 => [
                'school_name' => '盛岡大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            271 => [
                'school_name' => '聖マリア学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            272 => [
                'school_name' => '聖学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            273 => [
                'school_name' => '聖泉大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            274 => [
                'school_name' => '聖徳学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            275 => [
                'school_name' => '聖徳大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            276 => [
                'school_name' => '聖隷クリストファー大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            277 => [
                'school_name' => '西九州大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            278 => [
                'school_name' => '西南女学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            279 => [
                'school_name' => '西日本工業大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            280 => [
                'school_name' => '西武文理大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            281 => [
                'school_name' => '青森県営農大学校',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            282 => [
                'school_name' => '青森県立保健大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            283 => [
                'school_name' => '青森公立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            284 => [
                'school_name' => '青森大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            285 => [
                'school_name' => '青森中央学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            286 => [
                'school_name' => '青丹学園',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            287 => [
                'school_name' => '静岡県立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            288 => [
                'school_name' => '静岡産業大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            289 => [
                'school_name' => '静岡福祉大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            290 => [
                'school_name' => '静岡文化芸術大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            291 => [
                'school_name' => '静岡理工科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            292 => [
                'school_name' => '石川県立看護大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            293 => [
                'school_name' => '跡見学園女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            294 => [
                'school_name' => '摂南大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            295 => [
                'school_name' => '仙台大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            296 => [
                'school_name' => '仙台白百合女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            297 => [
                'school_name' => '千葉科学大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            298 => [
                'school_name' => '千葉経済大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            299 => [
                'school_name' => '千葉県立保健医療大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            300 => [
                'school_name' => '千葉工業大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            301 => [
                'school_name' => '千葉商科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            302 => [
                'school_name' => '千里金蘭大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            303 => [
                'school_name' => '川崎医療短期大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            304 => [
                'school_name' => '川崎医療福祉大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            305 => [
                'school_name' => '川村学園女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            306 => [
                'school_name' => '洗足学園音楽大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            307 => [
                'school_name' => '前橋工科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            308 => [
                'school_name' => '創価大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            309 => [
                'school_name' => '倉敷芸術科学大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            310 => [
                'school_name' => '相愛大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            311 => [
                'school_name' => '相模女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            312 => [
                'school_name' => '多摩大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            313 => [
                'school_name' => '太成学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            314 => [
                'school_name' => '帯広畜産大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            315 => [
                'school_name' => '大妻女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            316 => [
                'school_name' => '大阪音楽大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            317 => [
                'school_name' => '大阪学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            318 => [
                'school_name' => '大阪教育大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            319 => [
                'school_name' => '大阪経済大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            320 => [
                'school_name' => '大阪経済法科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            321 => [
                'school_name' => '大阪芸術大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            322 => [
                'school_name' => '大阪工業大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            323 => [
                'school_name' => '大阪行岡医療大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            324 => [
                'school_name' => '大阪国際大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            325 => [
                'school_name' => '大阪産業大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            326 => [
                'school_name' => '大阪歯科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            327 => [
                'school_name' => '大阪女学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            328 => [
                'school_name' => '大阪商業大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            329 => [
                'school_name' => '大阪樟蔭女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            330 => [
                'school_name' => '大阪信愛学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            331 => [
                'school_name' => '大阪成蹊大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            332 => [
                'school_name' => '大阪青山大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            333 => [
                'school_name' => '大阪総合保育大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            334 => [
                'school_name' => '大阪体育大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            335 => [
                'school_name' => '大阪大谷大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            336 => [
                'school_name' => '大阪電気通信大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            337 => [
                'school_name' => '大阪某大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            338 => [
                'school_name' => '大阪薬科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            339 => [
                'school_name' => '大手前大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            340 => [
                'school_name' => '大正大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            341 => [
                'school_name' => '大谷大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            342 => [
                'school_name' => '大東文化大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            343 => [
                'school_name' => '大同大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            344 => [
                'school_name' => '大分県立看護科学大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            345 => [
                'school_name' => '第一工業大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            346 => [
                'school_name' => '第一薬科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            347 => [
                'school_name' => '拓殖大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            348 => [
                'school_name' => '筑紫女学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            349 => [
                'school_name' => '筑波技術大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            350 => [
                'school_name' => '中央学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            351 => [
                'school_name' => '中京学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            352 => [
                'school_name' => '中京大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            353 => [
                'school_name' => '中村学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            354 => [
                'school_name' => '中部学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            355 => [
                'school_name' => '中部大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            356 => [
                'school_name' => '朝日大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            357 => [
                'school_name' => '長岡技術科学大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            358 => [
                'school_name' => '長岡造形大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            359 => [
                'school_name' => '長崎外国語大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            360 => [
                'school_name' => '長崎県立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            361 => [
                'school_name' => '長崎国際大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            362 => [
                'school_name' => '長崎純心大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            363 => [
                'school_name' => '長浜バイオ大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            364 => [
                'school_name' => '長野県看護大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            365 => [
                'school_name' => '長野大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            366 => [
                'school_name' => '長野平青学園',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            367 => [
                'school_name' => '鳥取大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            368 => [
                'school_name' => '追手門学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            369 => [
                'school_name' => '鶴見大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            370 => [
                'school_name' => '帝京科学大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            371 => [
                'school_name' => '帝京大学法学部',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            372 => [
                'school_name' => '帝京平成大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            373 => [
                'school_name' => '帝塚山学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            374 => [
                'school_name' => '帝塚山大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            375 => [
                'school_name' => '天使大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            376 => [
                'school_name' => '天理医療大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            377 => [
                'school_name' => '天理大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            378 => [
                'school_name' => '田園調布学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            379 => [
                'school_name' => '都内の国立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            380 => [
                'school_name' => '都内女子大',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            381 => [
                'school_name' => '都内美術大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            382 => [
                'school_name' => '都留文科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            383 => [
                'school_name' => '島根県立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            384 => [
                'school_name' => '島根大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            385 => [
                'school_name' => '東亜大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            386 => [
                'school_name' => '東海学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            387 => [
                'school_name' => '東海学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            388 => [
                'school_name' => '東海大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            389 => [
                'school_name' => '東京医療学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            390 => [
                'school_name' => '東京医療保健大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            391 => [
                'school_name' => '東京音楽大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            392 => [
                'school_name' => '東京家政学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            393 => [
                'school_name' => '東京家政大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            394 => [
                'school_name' => '東京学藝大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            395 => [
                'school_name' => '東京基督教大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            396 => [
                'school_name' => '東京経済大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            397 => [
                'school_name' => '東京工科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            398 => [
                'school_name' => '東京工芸大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            399 => [
                'school_name' => '東京国際大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            400 => [
                'school_name' => '東京歯科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            401 => [
                'school_name' => '東京純心女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            402 => [
                'school_name' => '東京純心大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            403 => [
                'school_name' => '東京女学館',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            404 => [
                'school_name' => '東京女子体育大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            405 => [
                'school_name' => '東京情報大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            406 => [
                'school_name' => '東京成徳大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            407 => [
                'school_name' => '東京聖栄大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            408 => [
                'school_name' => '東京造形大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            409 => [
                'school_name' => '東京電機大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            410 => [
                'school_name' => '東京都市大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            411 => [
                'school_name' => '東京富士大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            412 => [
                'school_name' => '東京福祉大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            413 => [
                'school_name' => '東京未来大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            414 => [
                'school_name' => '東京薬科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            415 => [
                'school_name' => '東京有明医療大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            416 => [
                'school_name' => '東京藝術大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            417 => [
                'school_name' => '東都医療大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            418 => [
                'school_name' => '東都大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            419 => [
                'school_name' => '東邦音楽大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            420 => [
                'school_name' => '東北医科薬科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            421 => [
                'school_name' => '東北学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            422 => [
                'school_name' => '東北芸術工科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            423 => [
                'school_name' => '東北工業大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            424 => [
                'school_name' => '東北女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            425 => [
                'school_name' => '東北生活文化大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            426 => [
                'school_name' => '東北福祉大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            427 => [
                'school_name' => '東北文化学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            428 => [
                'school_name' => '東洋英和女学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            429 => [
                'school_name' => '東洋学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            430 => [
                'school_name' => '桃山学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            431 => [
                'school_name' => '藤女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            432 => [
                'school_name' => '藤田医科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            433 => [
                'school_name' => '同志社女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            434 => [
                'school_name' => '同朋大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            435 => [
                'school_name' => '徳島工業短期大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            436 => [
                'school_name' => '徳島文理大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            437 => [
                'school_name' => '敦賀市立看護大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            438 => [
                'school_name' => '奈良学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            439 => [
                'school_name' => '奈良県立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            440 => [
                'school_name' => '奈良大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            441 => [
                'school_name' => '南九州大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            442 => [
                'school_name' => '二松学舎大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            443 => [
                'school_name' => '日本医療科学大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            444 => [
                'school_name' => '日本映画大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            445 => [
                'school_name' => '日本経済大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            446 => [
                'school_name' => '日本工業大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            447 => [
                'school_name' => '日本歯科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            448 => [
                'school_name' => '日本社会事業大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            449 => [
                'school_name' => '日本女子体育大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            450 => [
                'school_name' => '日本赤十字看護大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            451 => [
                'school_name' => '日本赤十字九州国際看護大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            452 => [
                'school_name' => '日本赤十字広島看護大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            453 => [
                'school_name' => '日本赤十字秋田看護大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            454 => [
                'school_name' => '日本赤十字豊田看護大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            455 => [
                'school_name' => '日本体育大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            456 => [
                'school_name' => '日本福祉大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            457 => [
                'school_name' => '日本文化大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            458 => [
                'school_name' => '日本文理大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            459 => [
                'school_name' => '日本保健医療大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            460 => [
                'school_name' => '日本薬科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            461 => [
                'school_name' => '梅花女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            462 => [
                'school_name' => '白鴎大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            463 => [
                'school_name' => '白梅学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            464 => [
                'school_name' => '白百合女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            465 => [
                'school_name' => '函館大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            466 => [
                'school_name' => '八戸工業大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            467 => [
                'school_name' => '比治山大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            468 => [
                'school_name' => '尾道市立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            469 => [
                'school_name' => '姫路大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            470 => [
                'school_name' => '姫路獨協大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            471 => [
                'school_name' => '浜松学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            472 => [
                'school_name' => '浜松大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            473 => [
                'school_name' => '富山県立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            474 => [
                'school_name' => '武蔵工業大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            475 => [
                'school_name' => '武蔵大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            476 => [
                'school_name' => '武蔵野音楽大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            477 => [
                'school_name' => '武蔵野学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            478 => [
                'school_name' => '武蔵野大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            479 => [
                'school_name' => '福井医療大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            480 => [
                'school_name' => '福井県立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            481 => [
                'school_name' => '福井工業大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            482 => [
                'school_name' => '福岡医療短期大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            483 => [
                'school_name' => '福岡教育大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            484 => [
                'school_name' => '福岡経済大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            485 => [
                'school_name' => '福岡県立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            486 => [
                'school_name' => '福岡工業大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            487 => [
                'school_name' => '福岡国際医療福祉大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            488 => [
                'school_name' => '福岡女学院',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            489 => [
                'school_name' => '福岡女学院看護大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            490 => [
                'school_name' => '福岡女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            491 => [
                'school_name' => '福岡大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            492 => [
                'school_name' => '福山大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            493 => [
                'school_name' => '福島学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            494 => [
                'school_name' => '福島県立医科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            495 => [
                'school_name' => '福島大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            496 => [
                'school_name' => '文化学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            497 => [
                'school_name' => '文化女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            498 => [
                'school_name' => '文京学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            499 => [
                'school_name' => '文教大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            500 => [
                'school_name' => '文星芸術大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            501 => [
                'school_name' => '兵庫医療大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            502 => [
                'school_name' => '兵庫県立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            503 => [
                'school_name' => '兵庫大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            504 => [
                'school_name' => '平安女学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            505 => [
                'school_name' => '平成国際大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            506 => [
                'school_name' => '別府大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            507 => [
                'school_name' => '札幌保健医療大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            508 => [
                'school_name' => '宝塚医療大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            509 => [
                'school_name' => '宝塚大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            510 => [
                'school_name' => '放送大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            511 => [
                'school_name' => '豊橋技術科学大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            512 => [
                'school_name' => '豊橋創造大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            513 => [
                'school_name' => '北海学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            514 => [
                'school_name' => '北海情報大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            515 => [
                'school_name' => '北海道医療大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            516 => [
                'school_name' => '北海道科学大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            517 => [
                'school_name' => '北海道教育大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            518 => [
                'school_name' => '北海道情報大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            519 => [
                'school_name' => '北海道職業能力開発大学校',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            520 => [
                'school_name' => '北海道文教大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            521 => [
                'school_name' => '北九州市立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            522 => [
                'school_name' => '北見工業大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            523 => [
                'school_name' => '北星学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            524 => [
                'school_name' => '北陸大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            525 => [
                'school_name' => '北翔大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            526 => [
                'school_name' => '麻布大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            527 => [
                'school_name' => '名寄市立大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            528 => [
                'school_name' => '名古屋音楽大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            529 => [
                'school_name' => '名古屋外国語大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            530 => [
                'school_name' => '名古屋学院大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            531 => [
                'school_name' => '名古屋学芸大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            532 => [
                'school_name' => '名古屋経済大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            533 => [
                'school_name' => '名古屋芸術大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            534 => [
                'school_name' => '名古屋商科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            535 => [
                'school_name' => '名古屋造形大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            536 => [
                'school_name' => '名古屋文理大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            537 => [
                'school_name' => '名桜大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            538 => [
                'school_name' => '名城大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            539 => [
                'school_name' => '明海大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            540 => [
                'school_name' => '明治国際医療大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            541 => [
                'school_name' => '明治薬科大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            542 => [
                'school_name' => '明星大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            543 => [
                'school_name' => '鳴門教育大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            544 => [
                'school_name' => '目白女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            545 => [
                'school_name' => '目白大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            546 => [
                'school_name' => '酪農学園大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            547 => [
                'school_name' => '藍野大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            548 => [
                'school_name' => '立正大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            549 => [
                'school_name' => '流通科学大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            550 => [
                'school_name' => '流通経済大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            551 => [
                'school_name' => '琉球大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            552 => [
                'school_name' => '龍谷大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            553 => [
                'school_name' => '了徳寺大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            554 => [
                'school_name' => '鈴鹿医療科学大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            555 => [
                'school_name' => '鈴鹿大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            556 => [
                'school_name' => '麗澤大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            557 => [
                'school_name' => '和光大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            558 => [
                'school_name' => '和洋女子大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            559 => [
                'school_name' => '佛教大学',
                'education_group' => EducationGroup::LessFamousUniv,
            ],
            560 => [
                'school_name' => 'フェリス女学院大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            561 => [
                'school_name' => '愛知教育大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            562 => [
                'school_name' => '茨城大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            563 => [
                'school_name' => '宇都宮大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            564 => [
                'school_name' => '横浜市立大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            565 => [
                'school_name' => '沖縄大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            566 => [
                'school_name' => '下関市立大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            567 => [
                'school_name' => '学習院女子大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            568 => [
                'school_name' => '岩手大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            569 => [
                'school_name' => '岐阜大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            570 => [
                'school_name' => '岐阜薬科大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            571 => [
                'school_name' => '宮城教育大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            572 => [
                'school_name' => '京都教育大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            573 => [
                'school_name' => '京都工芸繊維大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            574 => [
                'school_name' => '京都産業大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            575 => [
                'school_name' => '京都市立芸術大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            576 => [
                'school_name' => '京都薬科大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            577 => [
                'school_name' => '桐朋学園大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            578 => [
                'school_name' => '近畿大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            579 => [
                'school_name' => '金沢大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            580 => [
                'school_name' => '金沢美術工芸大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            581 => [
                'school_name' => '九州工業大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            582 => [
                'school_name' => '駒澤大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            583 => [
                'school_name' => '熊本県立農業大学校',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            584 => [
                'school_name' => '熊本大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            585 => [
                'school_name' => '群馬県立女子大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            586 => [
                'school_name' => '群馬大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            587 => [
                'school_name' => '工学院大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            588 => [
                'school_name' => '弘前大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            589 => [
                'school_name' => '甲南大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            590 => [
                'school_name' => '香川大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            591 => [
                'school_name' => '高崎経済大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            592 => [
                'school_name' => '国士舘大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            593 => [
                'school_name' => '国立音楽大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            594 => [
                'school_name' => '埼玉大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            595 => [
                'school_name' => '三重大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            596 => [
                'school_name' => '山梨大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            597 => [
                'school_name' => '産業能率大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            598 => [
                'school_name' => '私立専修大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            599 => [
                'school_name' => '滋賀大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            600 => [
                'school_name' => '鹿児島大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            601 => [
                'school_name' => '芝浦工業大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            602 => [
                'school_name' => '秋田大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            603 => [
                'school_name' => '順天堂大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            604 => [
                'school_name' => '小樽商科大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            605 => [
                'school_name' => '昭和音楽大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            606 => [
                'school_name' => '昭和女子大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            607 => [
                'school_name' => '昭和薬科大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            608 => [
                'school_name' => '上越教育大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            609 => [
                'school_name' => '信州大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            610 => [
                'school_name' => '新潟大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            611 => [
                'school_name' => '神戸女学院大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            612 => [
                'school_name' => '神戸薬科大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            613 => [
                'school_name' => '成城大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            614 => [
                'school_name' => '成蹊大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            615 => [
                'school_name' => '星薬科大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            616 => [
                'school_name' => '聖心女子大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            617 => [
                'school_name' => '聖路加国際大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            618 => [
                'school_name' => '西南学院大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            619 => [
                'school_name' => '静岡大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            620 => [
                'school_name' => '専修大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            621 => [
                'school_name' => '多摩美術大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            622 => [
                'school_name' => '大阪府立大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            623 => [
                'school_name' => '大分大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            624 => [
                'school_name' => '長崎大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            625 => [
                'school_name' => '津田塾大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            626 => [
                'school_name' => '帝京大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            627 => [
                'school_name' => '電気通信大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            628 => [
                'school_name' => '東京海洋大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            629 => [
                'school_name' => '東京学芸大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            630 => [
                'school_name' => '東京芸術大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            631 => [
                'school_name' => '東京女子大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            632 => [
                'school_name' => '東京農工大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            633 => [
                'school_name' => '東洋大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            634 => [
                'school_name' => '徳島大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            635 => [
                'school_name' => '奈良教育大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            636 => [
                'school_name' => '南山大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            637 => [
                'school_name' => '日本女子大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            638 => [
                'school_name' => '日本赤十字北海道看護大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            639 => [
                'school_name' => '日本大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            640 => [
                'school_name' => '富山大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            641 => [
                'school_name' => '武蔵野美術大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            642 => [
                'school_name' => '福井大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            643 => [
                'school_name' => '兵庫教育大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            644 => [
                'school_name' => '名古屋工業大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            645 => [
                'school_name' => '明治学院大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            646 => [
                'school_name' => '立命館アジア太平洋大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            647 => [
                'school_name' => '和歌山大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            648 => [
                'school_name' => '國學院大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            649 => [
                'school_name' => '獨協大学',
                'education_group' => EducationGroup::MediumStandardUniv,
            ],
            650 => [
                'school_name' => 'お茶の水女子大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            651 => [
                'school_name' => '横浜国立大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            652 => [
                'school_name' => '岡山大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            653 => [
                'school_name' => '学習院大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            654 => [
                'school_name' => '関西学院大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            655 => [
                'school_name' => '関西大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            656 => [
                'school_name' => '京都府立大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            657 => [
                'school_name' => '広島大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            658 => [
                'school_name' => '国際基督教大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            659 => [
                'school_name' => '首都大学東京',
                'education_group' => EducationGroup::FamousUniv,
            ],
            660 => [
                'school_name' => '昭和大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            661 => [
                'school_name' => '上智大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            662 => [
                'school_name' => '神戸市外国語大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            663 => [
                'school_name' => '神戸大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            664 => [
                'school_name' => '青山学院大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            665 => [
                'school_name' => '千葉大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            666 => [
                'school_name' => '大阪市立大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            667 => [
                'school_name' => '筑波大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            668 => [
                'school_name' => '中央大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            669 => [
                'school_name' => '東京外国語大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            670 => [
                'school_name' => '東京都立大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            671 => [
                'school_name' => '東京理科大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            672 => [
                'school_name' => '東邦大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            673 => [
                'school_name' => '同志社大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            674 => [
                'school_name' => '奈良女子大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            675 => [
                'school_name' => '奈良先端科学技術大学院大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            676 => [
                'school_name' => '日本獣医生命科学大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            677 => [
                'school_name' => '法政大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            678 => [
                'school_name' => '防衛大学校',
                'education_group' => EducationGroup::FamousUniv,
            ],
            679 => [
                'school_name' => '北里大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            680 => [
                'school_name' => '名古屋市立大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            681 => [
                'school_name' => '明治大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            682 => [
                'school_name' => '立教大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            683 => [
                'school_name' => '立命館大学',
                'education_group' => EducationGroup::FamousUniv,
            ],
            684 => [
                'school_name' => '愛知医科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            685 => [
                'school_name' => '旭川医科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            686 => [
                'school_name' => '一橋大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            687 => [
                'school_name' => '海外大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            688 => [
                'school_name' => '関西医科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            689 => [
                'school_name' => '岩手医科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            690 => [
                'school_name' => '京都大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            691 => [
                'school_name' => '京都府立医科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            692 => [
                'school_name' => '金沢医科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            693 => [
                'school_name' => '九州大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            694 => [
                'school_name' => '慶應義塾大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            695 => [
                'school_name' => '国際教養大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            696 => [
                'school_name' => '埼玉医科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            697 => [
                'school_name' => '埼玉医大',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            698 => [
                'school_name' => '札幌医科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            699 => [
                'school_name' => '産業医科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            700 => [
                'school_name' => '滋賀医科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            701 => [
                'school_name' => '自治医科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            702 => [
                'school_name' => '聖マリアンナ医科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            703 => [
                'school_name' => '川崎医科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            704 => [
                'school_name' => '早稲田大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            705 => [
                'school_name' => '大阪医科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            706 => [
                'school_name' => '大阪医科薬科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            707 => [
                'school_name' => '大阪大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            708 => [
                'school_name' => '東京医科歯科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            709 => [
                'school_name' => '東京医科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            710 => [
                'school_name' => '東京工業大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            711 => [
                'school_name' => '東京慈恵会医科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            712 => [
                'school_name' => '東京女子医科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            713 => [
                'school_name' => '東京大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            714 => [
                'school_name' => '東北大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            715 => [
                'school_name' => '奈良県立医科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            716 => [
                'school_name' => '日本医科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            717 => [
                'school_name' => '浜松医科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            718 => [
                'school_name' => '兵庫医科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            719 => [
                'school_name' => '防衛医科大学校',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            720 => [
                'school_name' => '北海道大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            721 => [
                'school_name' => '名古屋大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            722 => [
                'school_name' => '和歌山県立医科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
            723 => [
                'school_name' => '獨協医科大学',
                'education_group' => EducationGroup::MoreFamousUniv,
            ],
        ];
    }
}
