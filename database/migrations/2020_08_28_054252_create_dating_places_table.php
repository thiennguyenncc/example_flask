<?php

use Bachelor\Utility\Enums\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatingPlacesTable extends Migration
{
    /** Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        if(!Schema::hasTable('dating_places'))
            Schema::create('dating_places', function (Blueprint $table)
            {
                $table->id();
                $table->unsignedBigInteger('area_id');
                $table->unsignedBigInteger('train_station_id');
                $table->string('category');
                $table->double('latitude');
                $table->double('longitude');
                $table->double('rating');
                $table->string('display_phone');
                $table->string('phone');
                $table->string('reference_page_link');
                $table->tinyInteger('status')->default(Status::Active);
                $table->timestamps();
            });
    }

    /** Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('dating_places');
    }
}
