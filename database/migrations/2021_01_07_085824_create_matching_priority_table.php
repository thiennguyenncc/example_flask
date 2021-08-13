<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchingPriorityTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matching_priority', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedTinyInteger('gender');
            $table->unsignedInteger('dating_count');
            $table->unsignedInteger('review_count');
            $table->float('bachelor_coupon_point');
            $table->float('face_points');
            $table->float('personality_points');
            $table->float('last_satisfaction');
            $table->float('last_satisfaction_converted');
            $table->float('team_member_rate');
            $table->float('specific_addon');
            $table->float('starting_point');
            $table->float('review_point');
            $table->string('timing_text');
            $table->float('timing_point');
            $table->float('plan_point');
            $table->float('flex_point');
            $table->float('priority_points');

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
        Schema::dropIfExists('matching_priority');
    }
}
