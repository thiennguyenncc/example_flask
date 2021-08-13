<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OauthClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time_start = microtime(true);
        echo 'Oauth Clients Seeder started'. PHP_EOL;
        self::_seed();
        $time_end = microtime(true);
        Log::info('Oauth Clients Seeder finished | took ' . ($time_end - $time_start) . 's'.PHP_EOL);
    }

    /**
     *  Initiate the seeder
     */
    private function _seed()
    {
        DB::table('oauth_clients')->insert([
            'name' => 'Admin Password Grant',
            'secret' => 'MshBTafeS93OkUx3VfrEV4DdzR7GRFcTJguilUtv',
            'provider' => 'admin',
            'redirect' => 'http://localhost',
            'personal_access_client' => 0,
            'password_client' => 1,
            'revoked' => 0,
        ]);
    }
}
