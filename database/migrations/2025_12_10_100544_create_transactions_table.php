<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            // Link to the bill this transaction paid for
            $table->unsignedBigInteger('bill_id');

            // Link to the concessioner account
            $table->unsignedBigInteger('account_id');

            // Online payment details
            $table->string('reference_no');       // Public reference used by user
            $table->string('gateway_payment_id'); // HitPay or other gateway ID
            $table->string('payment_method');     // "online", "gcash", "hitpay"

            // Financial details
            $table->decimal('amount', 10, 2);
            $table->decimal('fee', 10, 2)->nullable();
            $table->decimal('net_amount', 10, 2)->nullable();

            // Status (paid, pending, failed, refunded)
            $table->string('status')->default('paid');

            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('bill_id')->references('id')->on('bill')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('concessioner_accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
