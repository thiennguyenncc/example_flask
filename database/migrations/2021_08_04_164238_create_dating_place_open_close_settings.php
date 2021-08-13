<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatingPlaceOpenCloseSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dating_place_open_close_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dating_place_id');
            $table->string('day_of_week');
            $table->time('open_at');
            $table->time('close_at');
            $table->timestamps();

            $table->foreign('dating_place_id')->references('id')->on('dating_places')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dating_place_open_close_settings');
    }
}
