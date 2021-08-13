<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsCronTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_cron_time', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('time_setting_id')->unsigned();
            $table->string('key',100);
            $table->string('command',100);
            $table->string('pattern');
            $table->timestamps();

            $table->foreign('time_setting_id')->references('id')->on('time_settings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings_cron_time');
    }
}
