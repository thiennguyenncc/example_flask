<?php

namespace Database\Seeders;

use Bachelor\Domain\MasterDataManagement\ReviewBox\Enums\FeedbackByGender;
use Bachelor\Domain\MasterDataManagement\ReviewBox\Enums\GoodBadType;
use Bachelor\Domain\MasterDataManagement\ReviewBox\Enums\Visible;
use Bachelor\Domain\MasterDataManagement\ReviewBox\Interfaces\ReviewBoxRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ReviewBoxForTestingSeeder extends Seeder
{
    protected ReviewBoxRepositoryInterface $reviewBoxRepository;

    public function __construct(ReviewBoxRepositoryInterface $reviewBoxRepository)
    {
        $this->reviewBoxRepository = $reviewBoxRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 0;
        while ($count < 150) {
            $this->reviewBoxRepository->create([
                'good_bad_type' => GoodBadType::getRandomValue(),
                'label' => '目がぱっちり' . $count,
                'description' => 'ぱっちりとした大きい目がキュートです' . $count,
                'feedback_by_gender' => FeedbackByGender::getRandomValue(),
                'visible' => Visible::true,
                'order_in_feedback' => rand(1,1000),
                'review_point_id' => rand(1,3),
                'star_category_id' => rand(1,19),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            $count ++;
        }
    }
}
