<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateRequestCancellationFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dating_user_cancel_form', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dating_user_id');
            $table->string('reason_for_cancellation')
                ->nullable();
            $table->string('reason_for_cancellation_other_text')
                ->nullable();
            $table->string('reason_for_cancellation_dissatisfaction_other_text')
                ->nullable();
            $table->string('detailed_reason')
                ->nullable();
            $table->timestamps();

            $table->foreign('dating_user_id')->references('id')->on('dating_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('dating_user_cancel_form');
        Schema::enableForeignKeyConstraints();
    }
}
