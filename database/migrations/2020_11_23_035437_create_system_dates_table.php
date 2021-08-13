<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('time_setting_id');
            $table->string('time_key');
            $table->timestamp('time_value')->useCurrent();
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
        Schema::dropIfExists('system_dates');
    }
}
