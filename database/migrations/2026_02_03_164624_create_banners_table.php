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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            
            // 1. Logic & Grouping
            $table->string('zone')->index();
            $table->string('type')->default('image'); // 'image' or 'video'
            
            // 2. Media Files
            $table->string('image_desktop'); // Main image / Video Poster
            $table->string('image_mobile')->nullable();
            $table->string('video_path')->nullable(); // Local MP4 Path
            
            // 3. Text Overlay
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('cta_text')->nullable();
            $table->string('cta_url')->nullable();
            
            // 4. Control
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
