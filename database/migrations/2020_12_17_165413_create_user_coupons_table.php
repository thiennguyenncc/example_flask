<?php

use Bachelor\Domain\UserManagement\UserCoupon\Enum\UserCouponCategory;
use Bachelor\Domain\UserManagement\UserCoupon\Enum\UserCouponStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_coupons', function (Blueprint $table)
        {
            $table->id('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('coupon_id');
            $table->unsignedBigInteger('dating_day_id')->nullable();
            $table->tinyInteger('status')->default(UserCouponStatus::Unused)->comment('1 : used, 2 : unused, 4 : exchanged, 5 : expired');
            $table->timestamp('expiry_at')->nullable();
            $table->timestamp('discarded_at')->nullable();
            $table->timestamps();

            // Relationship
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('coupon_id')->references('id')->on('coupons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_coupons');
    }
}
