<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('user_login'))
            Schema::create('user_login', function (Blueprint $table)
            {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id');
                $table->string('ip_address',50)
                    ->nullable();
                $table->timestamp('login_at')->useCurrent();
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('user_logins');
        Schema::enableForeignKeyConstraints();
    }
}
