<?php
namespace App\Console\Commands;

use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\User;
use Bachelor\Port\Secondary\Database\UserManagement\UserProfile\ModelDao\UserProfile;
use Bachelor\Port\Secondary\Database\UserManagement\UserPreference\ModelDao\UserPreference;

class BachelorUserGenerate extends BachelorBaseCommand
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bachelor:user_generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate users for bachelor';

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
        $numberOfUsers = 40;

        User::factory()->random()
            ->has(UserProfile::factory())
            ->has(UserPreference::factory())
            ->count($numberOfUsers)
            ->create();

        $this->info("Generated $numberOfUsers users successfully.");

        return 0;
    }
}
