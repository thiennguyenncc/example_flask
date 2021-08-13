<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAnalyticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('user_analytics'))
            Schema::create('user_analytics', function (Blueprint $table)
            {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id');
                $table->tinyInteger('registration_steps_completed');
                $table->timestamp('first_registration_completed_at')->useCurrent();
                $table->timestamp('previous_registration_completed_at')->useCurrent();
                $table->timestamp('first_approved_at')->useCurrent();
                $table->timestamp('first_trial_started_at')->useCurrent();
                $table->timestamp('first_trial_extended_at')->useCurrent();
                $table->timestamp('previous_trial_extended_at')->useCurrent();
                $table->string('http_referer')
                    ->nullable();
                $table->tinyInteger('is_sent_access_trade');
                $table->string('request_url')
                    ->nullable();
                $table->string('first_landing_page_url')
                    ->nullable();
                $table->timestamp('first_paid_term_started_at')->useCurrent();
                $table->timestamp('first_paid_term_login_at')->useCurrent();
                $table->timestamp('previous_deactivated_at')->useCurrent();
                $table->timestamp('previous_cancelled_at')->useCurrent();
                $table->timestamps();

                // Relationships
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_analytics');
    }
}
