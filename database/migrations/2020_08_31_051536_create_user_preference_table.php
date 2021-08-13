<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPreferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_preference', function (Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('age_from')->nullable();
            $table->tinyInteger('age_to')->nullable();
            $table->smallInteger('height_to')->nullable();
            $table->smallInteger('height_from')->nullable();
            $table->tinyInteger('partner_body_min')->nullable();
            $table->tinyInteger('partner_body_max')->nullable();
            $table->integer('smoking')->nullable();
            $table->integer('drinking')->nullable();
            $table->integer('divorce')->nullable();
            $table->integer('annual_income')->nullable();
            $table->integer('education')->nullable();
            $table->string('job', 100)->nullable();
            $table->string('face_preferences', 191);
            $table->integer('appearance_priority')->nullable();
            $table->integer('first_priority')->nullable();
            $table->integer('second_priority')->nullable();
            $table->integer('third_priority')->nullable();
            $table->integer('hobby')->nullable();
            $table->timestamps();

            // Relationships
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_preference');
    }
}
