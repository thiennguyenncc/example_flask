<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('name', 190);
            $table->unsignedInteger('default_language_id');
            $table->unsignedInteger('default_currency_id');
            $table->string('country_code', 20);
            $table->timestamps();

            // Relationships
            $table->foreign('default_currency_id', 'fk_currency_id')->references('id')->on('currencies');
            $table->foreign('default_language_id', 'fk_language_id')->references('id')->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('countries');
    }
}
