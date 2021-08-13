<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeOpenCloseAtNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dating_place_open_close_settings', function (Blueprint $table) {
            $table->time('open_at')->nullable()->change();
            $table->time('close_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dating_place_open_close_settings', function (Blueprint $table) {
            $table->time('open_at')->change();
            $table->time('close_at')->change();
        });
    }
}
