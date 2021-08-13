<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminActionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_action_logs', function (Blueprint $table) {
            $table->id();
            $table->char('batch_id', 36);
            $table->unsignedBigInteger('target_id')->nullable();
            $table->string('target_name')->nullable();
            $table->unsignedBigInteger('actionable_id')->nullable();
            $table->string('actionable_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('model_type')->nullable();
            $table->string('event_name')->nullable();
            $table->string('event_domain')->nullable();
            $table->string('event_type')->nullable();
            $table->string('method')->nullable();
            $table->text('data')->nullable();
            $table->string('status', 25)->nullable();
            $table->longText('exception')->nullable();
            $table->longText('original')->nullable();
            $table->longText('changes')->nullable();
            $table->timestamps();

            $table->index(['actionable_type', 'actionable_id']);
            $table->index(['batch_id', 'model_type', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_action_logs');
    }
}
