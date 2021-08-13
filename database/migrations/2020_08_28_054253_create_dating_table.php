<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dating', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dating_day_id');
            $table->timestamp('start_at')->nullable();
            $table->unsignedBigInteger('dating_place_id');
            $table->tinyInteger('status')->default(1)->comment('Status : 1 : Incomplete, 2 : Cancelled, 3 : Completed');
            $table->timestamps();
        });


        if (env('APP_ENV') != 'testing') {
            Schema::table('dating', function (Blueprint $table) {
                $table->foreign('dating_day_id')->references('id')->on('dating_days')->cascadeOnDelete();
                $table->foreign('dating_place_id')->references('id')->on('dating_places')->cascadeOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dating');
    }
}
