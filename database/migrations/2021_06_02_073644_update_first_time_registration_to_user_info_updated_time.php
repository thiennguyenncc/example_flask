<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFirstTimeRegistrationToUserInfoUpdatedTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_info_updated_time', function (Blueprint $table) {
            $table->timestamp('first_registration_completed_at')->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_info_updated_time', function (Blueprint $table) {
            $table->timestamp('first_registration_completed_at')->nullable()->after('user_id');
        });
    }
}
