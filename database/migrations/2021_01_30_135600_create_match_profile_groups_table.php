<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchProfileGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_profile_groups', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('text_align');
            $table->tinyInteger('age_from');
            $table->tinyInteger('age_to');
            $table->tinyInteger('gender');
            $table->softDeletes('deleted_at', 0);
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
        Schema::dropIfExists('match_profile_groups');
        Schema::enableForeignKeyConstraints();
    }
}
