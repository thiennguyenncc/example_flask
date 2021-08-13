<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipationOpenExpirySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participation_open_expiry_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('dating_day_of_week')->comment('wednesday, saturday, sunday');
            $table->tinyInteger('is_user_2nd_form_completed')->default(0)->comment('0 => false, 1 => true');
            $table->tinyInteger('user_gender')->comment('1 = male, 2 = female');
            $table->tinyInteger('open_days_before_dating_date')->nullable()->comment('from 3 to 20');
            $table->tinyInteger('expiry_days_before_dating_date')->nullable()->comment('from 3 to 20');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participation_open_expiry_settings');
    }
}
