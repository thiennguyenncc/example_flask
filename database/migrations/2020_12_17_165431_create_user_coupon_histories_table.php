<?php

use Bachelor\Domain\UserManagement\UserCoupon\Enum\UserCouponStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCouponHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_coupon_histories', function (Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('coupon_id');
            $table->unsignedBigInteger('user_coupon_id');
            $table->string('action')->default(UserCouponStatus::Unused);
            $table->unsignedTinyInteger('by_admin')->default(0)->comment('1 : Applied by admin , 0 : Given to the user by system');
            $table->timestamps();

            // Relationships
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('coupon_id')->references('id')->on('coupons');
            $table->foreign('user_coupon_id')->references('id')->on('user_coupons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_coupon_histories');
    }
}
