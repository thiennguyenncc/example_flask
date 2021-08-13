<?php

use Bachelor\Utility\Enums\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('email', 190)->unique();
            $table->string('password');
            $table->unsignedInteger('referred_by')->nullable()
                ->comment('ID of the admin who referred');
            $table->tinyInteger('status')->default(Status::Active)
                ->comment('1 = Active, 0 = Inactive');
            $table->string('ip_address', 30)->nullable()->default('127.0.0.1');
            $table->timestamp('last_login')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // Relationships
            $table->foreign('referred_by')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
