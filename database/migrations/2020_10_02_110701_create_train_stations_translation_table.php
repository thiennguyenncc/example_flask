<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainStationsTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('train_stations_translations', function (Blueprint $table)
        {
            $table->id();
            $table->unsignedBigInteger('train_station_id');
            $table->tinyInteger('language_id');
            $table->string('name');
            $table->timestamps();

            $table->foreign('train_station_id')->references('id')->on('train_stations')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('train_stations_translations');
    }
}
