<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orders_id');
            $table->string('xendit_external_id');
            $table->string('payment_type')->nullable();
            $table->string('transaction_status')->nullable();
            $table->decimal('gross_amount')->nullable();
            $table->string('invoice_url')->nullable();
            $table->datetime('expiry_time')->nullable();
            $table->datetime('transaction_time')->nullable();
            $table->timestamps();
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
