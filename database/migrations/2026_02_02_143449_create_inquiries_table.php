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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable(); // Opsional
            $table->string('subject')->nullable();
            $table->text('message');
            
            // Tracking Status
            $table->boolean('is_read')->default(false); // False = New, True = Read
            
            // Security Log
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable(); // Info Browser/Device
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
