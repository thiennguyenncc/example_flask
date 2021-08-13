<?php

namespace Database\Seeders;

use Bachelor\Domain\Communication\Chat\Enums\RoomType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomForTestingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->insert([
            'id' => '1_2',
            'name' => 'Bachelor private room',
            'created_by' => 1,
            'type' => RoomType::Twilio,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
