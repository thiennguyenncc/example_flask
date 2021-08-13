<?php

use Bachelor\Domain\Base\Language\Enums\Languages;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrefectureTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prefecture_translations', function (Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('prefecture_id');
            $table->tinyInteger('language_id')->default(Languages::Japanese()->toInt());
            $table->string('name');
            $table->timestamps();

            // Relationships
            $table->foreign('prefecture_id')->references('id')->on('prefectures')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prefecture_translations');
    }
}
