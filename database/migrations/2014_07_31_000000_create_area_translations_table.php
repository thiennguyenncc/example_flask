<?php

use Bachelor\Domain\Base\Language\Enums\Languages;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_translations', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('area_id');
            $table->tinyInteger('language_id')->default(Languages::Japanese()->toInt());
            $table->string('name');
            $table->timestamps();

            // Relationships
            $table->foreign('area_id')->references('id')->on('areas')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('area_translations');
    }
}
