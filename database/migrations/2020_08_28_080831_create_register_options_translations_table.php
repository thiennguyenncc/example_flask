<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegisterOptionsTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('register_options_translations', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('register_option_id');
            $table->unsignedInteger('language_id');
            $table->string('label_name', 255);
            $table->string('display_name', 255);
            $table->timestamps();

            // Relationships
            $table->foreign('register_option_id', 'fk_register_option_id')->references('id')->on('register_options');
            $table->foreign('language_id')->references('id')->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('register_options_translations');
    }
}
