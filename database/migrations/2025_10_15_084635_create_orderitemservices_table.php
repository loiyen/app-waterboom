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
        Schema::create('orderitemservices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orders_id');
            $table->foreignId('service_id');
            $table->integer('qty_service')->nullable();
            $table->decimal('price_service')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderitemservices');
    }
};
