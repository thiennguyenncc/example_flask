<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dating_id');
            $table->unsignedBigInteger('feedback_by');
            $table->unsignedBigInteger('feedback_for');
            $table->unsignedTinyInteger('last_satisfaction');
            $table->string('flex1')->nullable();
            $table->string('flex2')->nullable();
            $table->unsignedTinyInteger('dating_place_review')->default(0);
            $table->string('dating_place_review_comment')->nullable();
            $table->tinyInteger('able_to_use_dating_place')->nullable()->comment = '1 = true, 0 = false';
            $table->tinyInteger('why_not_able_to_use_dating_place')->nullable()->comment = '0 = other cafe, 1 = park, 2 = video';
            $table->string('dating_place_any_complaint')->nullable();
            $table->dateTime('discarded_at')->nullable();
            $table->tinyInteger('calculateable_dating_report')->default(1);
            $table->timestamps();

            $table->foreign('feedback_by')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->foreign('feedback_for')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->foreign('dating_id')
                ->references('id')
                ->on('dating')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedbacks');
    }
}
