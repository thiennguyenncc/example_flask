<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchingOverallPointsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matching_overall_points', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('base_user_id');
            $table->unsignedBigInteger('opponent_user_id');
            $table->float('face_points');
            $table->float('personality_points');
            $table->float('specific_addon_points');
            $table->float('starting_point');
            $table->float('face_type_point');
            $table->float('match_addition');
            $table->float('first_time_female_mismatch');
            $table->float('age_mismatch');
            $table->float('height_mismatch');
            $table->float('body_type_mismatch');
            $table->float('education_mismatch');
            $table->float('drinking_mismatch');
            $table->float('divorce_mismatch');
            $table->float('marriage_intention_mismatch');
            $table->float('hobby_mismatch');
            $table->float('job_mismatch');
            $table->float('smoking_mismatch');
            $table->float('annual_income_mismatch');
            $table->float('face_evaluation_mismatch');
            $table->string('exclusion', 190)->nullable();

            $table->float('partner_first_time_female_mismatch');
            $table->float('partner_age_mismatch');
            $table->float('partner_height_mismatch');
            $table->float('partner_body_type_mismatch');
            $table->float('partner_education_mismatch');
            $table->float('partner_drinking_mismatch');
            $table->float('partner_divorce_mismatch');
            $table->float('partner_marriage_intention_mismatch');
            $table->float('partner_hobby_mismatch');
            $table->float('partner_job_mismatch');
            $table->float('partner_smoking_mismatch');
            $table->float('partner_annual_income_mismatch');
            $table->float('partner_face_evaluation_mismatch');
            $table->string('partner_exclusion', 190)->nullable();
            $table->float('mismatch_reduction');
            $table->float('overall_points');
            $table->string('final_exclusion', 190)->nullable();

            $table->timestamps();

            $table->index([
                'base_user_id',
                'opponent_user_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matching_overall_points');
    }
}
