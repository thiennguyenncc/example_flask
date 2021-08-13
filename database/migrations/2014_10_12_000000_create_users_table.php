<?php

use Bachelor\Domain\UserManagement\Registration\Enums\RegistrationSteps;
use Bachelor\Domain\UserManagement\User\Enums\UserGender;
use Bachelor\Domain\UserManagement\User\Enums\UserStatus;
use Bachelor\Domain\UserManagement\User\Enums\IsFake;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 45)
                ->nullable();
            $table->tinyInteger('gender')
                ->nullable()
                ->comment('1 = Male User, 2 = Female User')
                ->default(NULL);
            $table->string('email', 100)
                ->unique()
                ->nullable();
            $table->string('mobile_number', 16)
                ->nullable();
            $table->tinyInteger('status')
                ->default(UserStatus::IncompleteUser);
            $table->tinyInteger('registration_steps')
                ->comment('Represents the number of registration steps user has successfully completed')
                ->default(RegistrationSteps::StepZero);
            $table->unsignedInteger('prefecture_id')
                ->default(1)
                ->comment('The city/region in a country to which user belongs to');
            $table->string('support_tracking_url', 45)
                ->nullable();
            $table->double('team_member_rate', 8, 2)
                ->comment('Rating of the user provided by the admin')
                ->default('0.00');
            $table->double('flex_point', 8, 2)
                ->comment('Flex Value of the user provided by the admin')
                ->default('0.00');
            $table->tinyInteger('is_fake')
                ->comment('determines if the user is a fake or real user')
                ->default(IsFake::RealUser);
            $table->string('invitation_code', 191)
                ->nullable();
            $table->string('invitation_url', 191)
                ->nullable();
            $table->timestamps();
        });

        if (env('APP_ENV') != 'testing') {
            Schema::table('users', function (Blueprint $table) {
                $table->foreign('prefecture_id')->references('id')->on('prefectures');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('users');
        Schema::enableForeignKeyConstraints();
    }
}
