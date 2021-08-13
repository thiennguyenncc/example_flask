<?php

use Bachelor\Port\Secondary\Database\Base\Admin\ModelDao\Admin;
use Bachelor\Utility\Enums\Status;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrefecturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prefectures', function (Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('country_id');
            $table->unsignedInteger('admin_id')->default(optional(Admin::first())->id);
            $table->string('name', 100);
            $table->tinyInteger('status')->default(Status::Active);
            $table->timestamps();

        });

        if (env('APP_ENV') != 'testing') {
            Schema::table('prefectures', function (Blueprint $table) {
                // Relationships
                $table->foreign('country_id')->references('id')->on('countries')->cascadeOnDelete();
                $table->foreign('admin_id')->references('id')->on('admins');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prefectures');
    }
}
