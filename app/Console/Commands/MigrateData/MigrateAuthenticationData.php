<?php

namespace App\Console\Commands\MigrateData;

use App\Console\Commands\BachelorBaseCommand;
use App\Imports\Authentication\OauthAccessTokensImport;
use App\Imports\Authentication\OauthAuthCodesImport;
use App\Imports\Authentication\OauthClientsImport;
use App\Imports\Authentication\OauthPersonalAccessClientsImport;
use App\Imports\Authentication\OauthRefreshTokensImport;
use App\Imports\Authentication\UserImport;
use Bachelor\Utility\Helpers\Log;
use Maatwebsite\Excel\Facades\Excel;

class MigrateAuthenticationData extends BachelorBaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:authentication';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate authentication data from old system to new system';

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
            $this->info('Start migrate');
            $oauthAccessTokensPath = storage_path('/data-migrate/oauth_access_tokens.csv');
            $oauthAuthCodesPath = storage_path('/data-migrate/oauth_auth_codes.csv');
            $oauthClientsPath = storage_path('/data-migrate/oauth_clients.csv');
            $oauthPersonalAccessClientsPath = storage_path('/data-migrate/oauth_personal_access_clients.csv');
            $oauthRefreshTokensPath = storage_path('/data-migrate/oauth_refresh_tokens.csv');
            $usersPath = storage_path('/data-migrate/users.csv');

            if (file_exists($oauthAccessTokensPath)) {
                $this->info('Migrate oauth access tokens data start');
                Excel::import(new OauthAccessTokensImport(), $oauthAccessTokensPath);
                Log::info('Migrate oauth access tokens data end');
            }
            if (file_exists($oauthAuthCodesPath)) {
                $this->info('Migrate oauth auth codes data start');
                Excel::import(new OauthAuthCodesImport(), $oauthAuthCodesPath);
                Log::info('Migrate oauth auth codes data end');
            }
            if (file_exists($oauthClientsPath)) {
                $this->info('Migrate oauth clients data start');
                Excel::import(new OauthClientsImport(), $oauthClientsPath);
                Log::info('Migrate oauth clients data end');
            }
            if (file_exists($oauthPersonalAccessClientsPath)) {
                $this->info('Migrate oauth personal access clients data start');
                Excel::import(new OauthPersonalAccessClientsImport(), $oauthPersonalAccessClientsPath);
                Log::info('Migrate oauth personal access clients data end');
            }
            if (file_exists($oauthRefreshTokensPath)) {
                $this->info('Migrate oauth refresh tokens data start');
                Excel::import(new OauthRefreshTokensImport(), $oauthRefreshTokensPath);
                Log::info('Migrate oauth refresh tokens data end');
            }
            if (file_exists($usersPath)) {
                $this->info('Migrate users and user auth and user login data start');
                Excel::import(new UserImport(), $usersPath);
                Log::info('Migrate users and user auth and user login data end');
            }

            $this->info('Migrate all data end');

        } catch (\Exception $exception) {
            $this->info($exception->getMessage());
        }
    }
}
