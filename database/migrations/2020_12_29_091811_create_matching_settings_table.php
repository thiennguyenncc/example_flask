<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Bachelor\Domain\DatingManagement\Matching\Enums\MatchingSettingType;

class CreateMatchingSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matching_settings', function (Blueprint $table) {
            $table->id();
            $table->string('setting_key');
            $table->string('value');
            $table->unsignedInteger('category');
            $table->unsignedTinyInteger('type')->default(MatchingSettingType::PriorityPoint);
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
        Schema::dropIfExists('matching_settings');
    }
}
