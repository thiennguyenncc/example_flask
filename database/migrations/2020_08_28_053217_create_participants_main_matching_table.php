<?php

use Bachelor\Domain\DatingManagement\ParticipantMainMatch\Enums\ParticipantsStatus;
use Bachelor\Utility\Enums\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsMainMatchingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants_main_matching', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('dating_day_id');
            $table->tinyInteger('status')->default(ParticipantsStatus::Awaiting);
            $table->tinyInteger('show_sample_date')->default(Status::Inactive);
            $table->timestamps();
        });

        if (env('APP_ENV') != 'testing') {
            Schema::table('participants_main_matching', function (Blueprint $table) {
                $table->unique(['user_id', 'dating_day_id']);
                // Relationships
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('dating_day_id')->references('id')->on('dating_days')->onDelete('cascade');
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
        Schema::dropIfExists('participants_main_matching');
    }
}
