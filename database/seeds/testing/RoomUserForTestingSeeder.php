<?php

namespace Database\Seeders;

use Bachelor\Domain\Communication\Chat\Enums\RoomType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomUserForTestingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('room_users')->insert([
            [
                'user_id' => 1,
                'room_id' => '1_2',
                'type' => RoomType::Twilio,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 2,
                'room_id' => '1_2',
                'type' => RoomType::Twilio,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
