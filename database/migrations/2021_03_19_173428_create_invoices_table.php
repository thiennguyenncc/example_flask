<?php

use Bachelor\Domain\PaymentManagement\Invoice\Enum\InvoiceStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_payment_customer_id');
            $table->unsignedBigInteger('subscription_id')->nullable();
            $table->string('description');
            $table->integer('status')->default(InvoiceStatus::Draft);
            $table->tinyInteger('auto_advance')->default(1);
            $table->string('third_party_invoice_id');
            $table->string('hosted_invoice_url')->nullable();
            $table->dateTime('grace_period_starts_at')->nullable();
            $table->dateTime('grace_period_ends_at')->nullable();
            $table->timestamps();

            $table->foreign('user_payment_customer_id')
                ->references('id')
                ->on('user_payment_customers')
                ->cascadeOnDelete();
            $table->foreign('subscription_id')
                ->references('id')
                ->on('subscriptions')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
