<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeStarCategoryIdFieldOnReviewBoxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('review_boxes', function (Blueprint $table) {
            $table->unsignedInteger('star_category_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('review_boxes', function (Blueprint $table) {
            $table->unsignedInteger('star_category_id')->change();
        });
    }
}
