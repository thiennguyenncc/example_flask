<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropInvitaionCodeAndInvitationUrlInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('invitation_code');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('invitation_url');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('invitation_code', 191);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('invitation_url', 191);
        });
    }
}
