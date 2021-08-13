<?php

use Bachelor\Domain\Base\Country\Enums\Countries;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatingPlaceTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('dating_place_translations'))
            Schema::create('dating_place_translations', function (Blueprint $table)
            {
                $table->id();
                $table->unsignedBigInteger('dating_place_id');
                $table->tinyInteger('language_id');
                $table->string('name');
                $table->string('display_address');
                $table->string('city');
                $table->string('zip_code', 10)->default(000000);
                $table->timestamps();

                $table->foreign('dating_place_id')->references('id')->on('dating_places')->cascadeOnDelete();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dating_place_translations');
    }
}
