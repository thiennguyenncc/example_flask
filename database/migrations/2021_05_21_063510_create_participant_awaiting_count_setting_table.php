<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantAwaitingCountSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participant_awaiting_count_setting', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('dating_day_id');
            $table->unsignedTinyInteger('gender');
            $table->integer('prefecture_id');
            $table->string('type');
            $table->decimal('count')->nullable();
            $table->timestamps();
            $table->unique(['dating_day_id', 'gender', 'prefecture_id', 'type'], 'uniq_participant_awaiting_count');
        });
        if (env('APP_ENV') != 'testing')
        {
            Schema::table('participant_awaiting_count_setting', function (Blueprint $table) {
                $table->foreign('dating_day_id')->references('id')
                    ->on('dating_days')->onDelete('cascade');
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
        Schema::dropIfExists('participant_awaiting_count_setting');
    }
}
