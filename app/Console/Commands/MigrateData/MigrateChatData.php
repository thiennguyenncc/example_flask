<?php

namespace App\Console\Commands\MigrateData;

use App\Console\Commands\BachelorBaseCommand;
use App\Imports\CursorImport;
use App\Imports\MessageImport;
use App\Imports\RoomImport;
use App\Imports\RoomUserImport;
use \Excel;
use Illuminate\Support\Facades\Log;

class MigrateChatData extends BachelorBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:chat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->info('start migrate');
            $roomPath = storage_path('/data-migrate/rooms.csv');
            $roomUserPath = storage_path('/data-migrate/room_users.csv');
            $messagePath = storage_path('/data-migrate/messages.csv');
            $cursorPath = storage_path('/data-migrate/cursor.csv');
            if (file_exists($roomPath)) {
                Log::info('migrate rooms data');
                Excel::import(new RoomImport, $roomPath);
                Log::info('migrate rooms data success');
            }
            if (file_exists($roomUserPath)) {
                Log::info('migrate room user data');
                Excel::import(new RoomUserImport, $roomUserPath);
                Log::info('migrate room user data success');
            }
            if (file_exists($messagePath)) {
                Log::info('start migrate messages data');
                Excel::import(new MessageImport, $messagePath);
                Log::info('migrate rooms messages success');
            }
            if (file_exists($cursorPath)) {
                Log::info('start migrate cursor data');
                Excel::import(new CursorImport, $cursorPath);
                Log::info('migrate cursor success');
            }
            $this->info('migrate all data success');
        } catch (\Exception $e) {
            $this->info($e->getMessage());
            Log::error($e->getMessage());
        }
    }

}
