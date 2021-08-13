<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantRecommendationSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participant_recommendation_setting', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dating_day_id');
            $table->unsignedTinyInteger('gender');
            $table->unsignedTinyInteger('days_before');
            $table->float('ratio')->comment('Female/Male ratio');

            $table->timestamps();

            $table->unique(['dating_day_id', 'gender', 'days_before'], 'uniq_recommend_date_gender_days');
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
        Schema::dropIfExists('participant_recommendation_setting');
    }
}
