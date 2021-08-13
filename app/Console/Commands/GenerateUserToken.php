<?php

namespace App\Console\Commands;

use Bachelor\Port\Secondary\Database\UserManagement\User\ModelDao\UserAuth;
use Illuminate\Support\Facades\Auth;

class GenerateUserToken extends BachelorBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:generate_token {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manually generate user token';

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
     * @return void
     */
    public function handle()
    {
        $authId = $this->argument('id');

        $this->info($authId);

        /* @var UserAuth $userAuth */
        $userAuth = Auth::loginUsingId($authId);

        $token = $userAuth->createToken('UserToken', ['*'])->accessToken;

        $this->info($token);
    }
}
