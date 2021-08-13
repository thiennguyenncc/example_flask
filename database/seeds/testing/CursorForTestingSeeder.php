<?php

namespace Database\Seeders;

use Bachelor\Domain\Communication\Chat\Enums\RoomType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CursorForTestingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $messages = DB::table('messages')->get();

        foreach ($messages as $message) {
            DB::table('cursor')->insert([
                'room_id' => '1_2',
                'user_id' => 1,
                'message_id' => $message->id,
                'type' => RoomType::Twilio,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
