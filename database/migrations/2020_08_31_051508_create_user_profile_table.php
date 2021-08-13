<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profile', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->date('birthday');
            $table->integer('height')->nullable();
            $table->integer('body_type')->nullable();
            $table->integer('marriage_intention')->nullable();
            $table->string('character', 100)->nullable();
            $table->integer('smoking')->nullable();
            $table->integer('drinking')->nullable();
            $table->string('divorce', 45)->nullable();
            $table->integer('annual_income')->nullable();
            $table->string('appearance_strength', 255)->nullable();
            $table->string('appearance_features', 255)->nullable();
            $table->string('education', 45)->nullable();
            $table->unsignedBigInteger('school_id')->nullable();
            $table->string('company_name', 100)->nullable();
            $table->integer('job')->nullable();
            $table->string('hobby', 200)->nullable();
            $table->timestamps();
        });

        if (env('APP_ENV') != 'testing') {
            Schema::table('user_profile', function (Blueprint $table) {
                // Relationships
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('school_id')->references('id')->on('schools')->nullable()->onDelete('cascade');
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
        Schema::dropIfExists('user_profile');
    }
}
