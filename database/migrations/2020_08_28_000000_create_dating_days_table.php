<?php

use Bachelor\Utility\Enums\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatingDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dating_days', function (Blueprint $table)
        {
            $table->id();
            $table->string('dating_day');
            $table->date('dating_date');
//            $table->unsignedTinyInteger('status')->default(Status::Inactive)->comment('0 = closed, 1 = opened, 2 = expired');
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('dating_days');
        Schema::enableForeignKeyConstraints();
    }
}
