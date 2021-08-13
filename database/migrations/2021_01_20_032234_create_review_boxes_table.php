<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_boxes', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('good_bad_type')->comment('1: Complaint, 2: Good factor');
            $table->string('label');
            $table->string('description')->nullable();
            $table->tinyInteger('feedback_by_gender')->comment('1: Male, 2: Female, 3: Both');
            $table->tinyInteger('visible')->default(1)->comment('0: Invisible, 1: Visible');
            $table->integer('order_in_feedback');
            $table->unsignedInteger('review_point_id');
            $table->unsignedInteger('star_category_id');
            $table->timestamps();

            $table->foreign('review_point_id')->references('id')->on('review_points');
            $table->foreign('star_category_id')->references('id')->on('star_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review_boxes');
    }
}
