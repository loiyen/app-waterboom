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
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->string('position')->nullable();
            $table->string('slug')->nullable();
            $table->string('department')->nullable();
            $table->longText('description')->nullable();
            $table->longText('requirements')->nullable();
            $table->enum('job_type', [
                'full_time',
                'part_time',
                'internship'
            ])->default('full_time');
            $table->string('image')->nullable();
            $table->longText('benefits')->nullable();
            $table->date('deadline')->nullable();
            $table->boolean('is_active')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};
