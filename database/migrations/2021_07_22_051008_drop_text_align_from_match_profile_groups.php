<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropTextAlignFromMatchProfileGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('match_profile_groups', function (Blueprint $table) {
            $table->dropColumn('text_align');
        });
        Schema::rename('match_profile_groups', 'match_info_groups');
        Schema::rename('match_profiles', 'match_infos');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('match_info_groups', 'match_profile_groups');
        Schema::rename('match_infos', 'match_profiles');
        Schema::table('match_profile_groups', function (Blueprint $table) {
            $table->string('text_align');
        });
    }
}
