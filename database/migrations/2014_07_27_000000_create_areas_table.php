<?php

use Bachelor\Port\Secondary\Database\Base\Admin\ModelDao\Admin;
use Bachelor\Utility\Enums\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->unsignedInteger('prefecture_id');
            $table->string('name', 255);
            $table->tinyInteger('status')->default(Status::Active);
            $table->unsignedInteger('admin_id')->default(optional(Admin::first())->id);
            $table->timestamps();

            // Relationships
            $table->foreign('prefecture_id')->references('id')->on('prefectures')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('areas');
    }
}
