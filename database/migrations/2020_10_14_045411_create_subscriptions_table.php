<?php

use Bachelor\Domain\PaymentManagement\Subscription\Enum\SubscriptionStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_payment_customer_id');
            $table->unsignedBigInteger('third_party_subscription_id');
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('next_starts_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->string('status')->default(SubscriptionStatus::Active);
            $table->string('pause_collection_behavior')->nullable();
            $table->timestamps();

            $table->foreign('user_payment_customer_id')->references('id')->on('user_payment_customers')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
