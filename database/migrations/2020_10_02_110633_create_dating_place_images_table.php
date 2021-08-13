<?php

use Bachelor\Utility\Enums\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatingPlaceImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dating_place_images', function (Blueprint $table)
        {
            $table->id();
            $table->unsignedBigInteger('dating_place_id');
            $table->string('image');
            $table->tinyInteger('status')->default(Status::Active);
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
        Schema::dropIfExists('dating_place_images');
    }
}
