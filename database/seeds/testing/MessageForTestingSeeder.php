<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MessageForTestingSeeder extends Seeder
{
    const LIMIT = 100;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 0;
        while($count < self::LIMIT) {
            DB::table('messages')->insert([
                'user_id' => rand(1,2),
                'room_id' => '1_2',
                'content' => Str::random(rand(1, 200)),
                'type' => 'twilio',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            $count ++;
        }
    }
}
