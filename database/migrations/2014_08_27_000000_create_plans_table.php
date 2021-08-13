<?php

use Bachelor\Domain\PaymentManagement\Plan\Enum\DiscountType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->string('nickname', 120);
            $table->string('third_party_plan_id', 100);
            $table->string('discount_type', 45)->default(DiscountType::NoDiscount);
            $table->integer('contract_term')->default(1)->comment("month");
            $table->string('cost_plan', 45);
            $table->decimal('final_amount', 10, 2);
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
        Schema::dropIfExists('plans');
    }
}
