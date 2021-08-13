<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackUserReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback_user_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('feedback_id');
            $table->integer('face_points');
            $table->integer('personality_points');
            $table->longText('face_complaint')->nullable();
            $table->longText('face_good_factor')->nullable();
            $table->string('face_other_comment')->nullable();
            $table->longText('personality_complaint')->nullable();
            $table->longText('personality_good_factor')->nullable();
            $table->string('personality_other_comment')->nullable();
            $table->longText('behaviour_complaint')->nullable();
            $table->longText('behaviour_good_factor')->nullable();
            $table->string('behaviour_other_comment')->nullable();
            $table->integer('behaviour_points');
            $table->unsignedInteger('body_shape')->default(0);
            $table->string('the_better_point')->nullable();
            $table->string('the_worse_point')->nullable();
            $table->string('comment_something_different')->nullable();
            $table->integer('b_suitable')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedback_user_reviews');
    }
}
