<?php

namespace Database\Seeders;

use App\Console\Commands\CreateMatchingDate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LanguageSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(RegistrationOptionSeeder::class);
        $this->call(TimeSettingSeeder::class);
        $this->call(CouponSeeder::class);
        $this->call(SchoolSeeder::class);
        $this->call(MatchingSettingTableSeeder::class);
        $this->call(PlanSeeder::class);
        $this->call(NotificationSeeder::class);

        if (config('app.env') == 'testing') {
            $this->call(AdminSeeder::class);
            $this->call(PrefectureSeeder::class);
            $this->call(PaymentProviderSeeder::class);
            $this->call(OauthClientsSeeder::class);
            $this->call(UserSeeder::class);
            $this->call(AreaSeeder::class);
            $this->call(TrainStationSeeder::class);
            $this->call(DatingPlaceSeeder::class);
            Artisan::call(CreateMatchingDate::class);
            $this->call(ParticipantAwaitingCancelSettingForTestingSeeder::class);
            $this->call(ParticipantAwaitingCountSettingForTestingSeeder::class);
            $this->call(ParticipantRecommendationSettingForTestingSeeder::class);
            $this->call(ParticipantForMainMatchOrRematchForTestingSeeder::class);
            $this->call(TrainStationAndTrainStationTranslationForTestingSeeder::class);
            $this->call(DatingPlaceAndDatingPlaceTranslationForTestingSeeder::class);
            $this->call(ReviewPointForTestingSeeder::class);
            $this->call(StarCategoryForTestingSeeder::class);
            $this->call(ReviewBoxForTestingSeeder::class);
            $this->call(DatingAndDatingUserForTestingSeeder::class);
            $this->call(RoomForTestingSeeder::class);
            $this->call(RoomUserForTestingSeeder::class);
            $this->call(MessageForTestingSeeder::class);
            $this->call(CursorForTestingSeeder::class);
        }
    }
}
