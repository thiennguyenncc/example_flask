<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserAccountMigrationLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_account_migration_logs', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('deactivated_user_id');
            $table->string('email', 100)->nullable();
            $table->string('deactivated_email', 100)->nullable();
            $table->string('mobile_number', 14)->nullable();
            $table->string('auth_type', 20)->nullable();
            $table->string('deactivated_auth_type', 20)->nullable();
            $table->string('participation_ids', 500)->nullable()->comment('All the participation ids of deactivated account');
            $table->string('dating_ids', 500)->nullable();
            $table->string('user_ids',190)->nullable()->comment('Stores all the user ids to which the mobile number belongs to');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('deactivated_user_id','foreign_deactivated_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_account_migration_logs');
    }
}
