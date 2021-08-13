<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDatetimeColumnToTimestamp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dating_days', function (Blueprint $table) {
            $table->dropColumn('dating_date');
        });
        Schema::table('dating_reports', function (Blueprint $table) {
            $table->dropColumn('display_date');
        });
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->dropColumn('discarded_at');
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('grace_period_starts_at');
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('grace_period_ends_at');
        });
        Schema::table('notification_email_messages', function (Blueprint $table) {
            $table->dropColumn('read_at');
        });
        Schema::table('dating_days', function (Blueprint $table) {
            $table->timestamp('dating_date')->nullable();
        });
        Schema::table('dating_reports', function (Blueprint $table) {
            $table->timestamp('display_date')->nullable();
        });
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->timestamp('discarded_at')->nullable();
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->timestamp('grace_period_starts_at')->nullable();

        });
        Schema::table('invoices', function (Blueprint $table) {

            $table->timestamp('grace_period_ends_at')->nullable();
        });
        Schema::table('notification_email_messages', function (Blueprint $table) {
            $table->timestamp('read_at')->nullable();
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
        Schema::table('dating_reports', function (Blueprint $table) {
            $table->dropColumn('display_date');
        });
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->dropColumn('discarded_at');
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('grace_period_starts_at');

        });
        Schema::table('invoices', function (Blueprint $table) {

            $table->dropColumn('grace_period_ends_at');
        });
        Schema::table('notification_email_messages', function (Blueprint $table) {
            $table->dropColumn('read_at');
        });
        Schema::table('dating_days', function (Blueprint $table) {
            $table->date('dating_date')->default("1900-01-01");
        });
        Schema::table('dating_reports', function (Blueprint $table) {
            $table->dateTime('display_date')->nullable();
        });
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->dateTime('discarded_at')->nullable();
        });
        Schema::table('invoices', function (Blueprint $table) {
            $table->dateTime('grace_period_starts_at')->nullable();

        });
        Schema::table('invoices', function (Blueprint $table) {

            $table->dateTime('grace_period_ends_at')->nullable();
        });
        Schema::table('notification_email_messages', function (Blueprint $table) {
            $table->dateTime('read_at')->nullable();
        });
    }
}
