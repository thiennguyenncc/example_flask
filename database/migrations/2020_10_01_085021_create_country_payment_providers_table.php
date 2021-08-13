<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Bachelor\Utility\Enums\Status;
class CreateCountryPaymentProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_payment_providers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('payment_provider_id');
            $table->unsignedInteger('country_id');
            $table->unsignedTinyInteger('status')->default(Status::Active);
            $table->timestamps();
            
            $table->foreign('payment_provider_id')->references('id')->on('payment_providers')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('country_payment_providers');
    }
}
