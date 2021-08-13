<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantAwaitingCancelSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participant_awaiting_cancel_setting', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dating_day_id');
            $table->unsignedTinyInteger('gender');
            $table->unsignedTinyInteger('days_before');
            $table->float('ratio')->comment('Female/Male ratio');

            $table->timestamps();

            $table->unique(['dating_day_id', 'gender', 'days_before'], 'uniq_date_gender_days_cancel_setting');
            $table->foreign('dating_day_id')->references('id')
                ->on('dating_days')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participant_awaiting_cancel_setting');
    }
}
