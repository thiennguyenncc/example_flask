<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDatingDateFormat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dating_days', function (Blueprint $table) {
            $table->date('dating_date')->change();
        });
        Schema::table('dating', function (Blueprint $table) {
            $table->time('start_at')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dating_days', function (Blueprint $table) {
            $table->dropColumn('dating_date');
        });
        Schema::table('dating_days', function (Blueprint $table) {
            $table->timestamp('dating_date')->nullable();
        });
        Schema::table('dating', function (Blueprint $table) {
            $table->dropColumn('start_at');
        });
        Schema::table('dating', function (Blueprint $table) {
            $table->timestamp('start_at')->nullable();
        });
    }
}
