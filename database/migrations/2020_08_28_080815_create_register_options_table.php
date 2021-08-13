<?php

use Bachelor\Utility\Enums\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisterOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_options', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->string('option_key', 255);
            $table->string('option_value', 45);
            $table->string('type', 45);
            $table->tinyInteger('allowed_gender')->nullable();
            $table->integer('sort');
            $table->tinyInteger('status')
                ->default(Status::Active);
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
        Schema::dropIfExists('register_options');
    }
}
