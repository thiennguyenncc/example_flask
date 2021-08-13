<?php

use Bachelor\Domain\AuthenticationManagement\Authentication\Enums\UserAuthType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAuthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_auth', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('auth_type')
                ->default(UserAuthType::Mobile);
            $table->string('auth_id');
            $table->string('access_token')
                ->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        if (env('APP_ENV') != 'testing') {
            Schema::table('user_auth', function (Blueprint $table) {
                // Relationships
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('user_auth');
    }
}
