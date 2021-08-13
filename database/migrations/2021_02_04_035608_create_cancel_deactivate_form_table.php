<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCancelDeactivateFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cancel_deactivate_form', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->tinyInteger('type')->comment('1: Cancel, 2: Deactivate');
            $table->string('reason_about_date')->nullable();
            $table->string('reason_about_date_other_text')->nullable();
            $table->string('reason_about_date_i_not_prefer_other_text')->nullable();
            $table->string('reason_about_service')->nullable();
            $table->string('reason_about_service_other_text')->nullable();
            $table->string('improvements_feedback')->nullable();
            $table->string('other_opinion_feedback')->nullable();
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
        Schema::dropIfExists('cancel_deactivate_form');
    }
}
