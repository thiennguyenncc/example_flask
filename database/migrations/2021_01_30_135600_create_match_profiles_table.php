<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_profiles', function (Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('group_id');
            $table->string('description');
            $table->string('image');
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();

            // Relationships
            $table->foreign('group_id')->references('id')->on('match_profile_groups');
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
        Schema::dropIfExists('match_profiles');
        Schema::enableForeignKeyConstraints();
    }
}
