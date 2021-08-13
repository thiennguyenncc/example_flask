<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AllowNullBirthdaySchoolIdFacePreferences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_profile', function($table)
        {
            $table->date('birthday')->nullable()->change();
        });

        Schema::table('user_preference', function($table)
        {
            $table->string('face_preferences', 191)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_profile', function($table)
        {
            $table->date('birthday')->nullable(false)->change();
        });

        Schema::table('user_preference', function($table)
        {
            $table->string('face_preferences', 191)->nullable(false)->change();
        });
    }
}
