<?php

use Bachelor\Domain\UserManagement\Registration\Enums\RegistrationSteps;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRegistrationStepsColumnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->smallInteger('registration_steps')->nullable()->default(null)->change();
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
            $table->smallInteger('registration_steps')
                ->comment('Represents the number of registration steps user has successfully completed')
                ->default(RegistrationSteps::StepZero)->change();
        });
    }
}
