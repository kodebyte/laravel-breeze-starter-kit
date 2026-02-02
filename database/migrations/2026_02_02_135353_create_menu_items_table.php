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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            
            // Label Menu (JSON biar support Multi-bahasa ID/EN)
            $table->json('label'); 
            
            // Link/URL
            // Kita pisah: kalau dia link ke Page ID 1, kolom 'page_id' diisi.
            // Kalau dia link manual (misal: google.com), kolom 'url' diisi.
            $table->string('url')->nullable(); 
            $table->foreignId('page_id')->nullable()->constrained('pages')->nullOnDelete();
            
            // Hierarchy & Order
            $table->foreignId('parent_id')->nullable()->constrained('menu_items')->cascadeOnDelete();
            $table->integer('order')->default(0);
            
            // Config Tambahan
            $table->string('target')->default('_self'); // _self atau _blank
            $table->string('icon_class')->nullable(); // Kalau mau ada icon di menu
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
