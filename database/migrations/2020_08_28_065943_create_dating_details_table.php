<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dating_users', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dating_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();

            // Relationships
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('dating_id')->references('id')->on('dating')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dating_users');
    }
}
